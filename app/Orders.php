<?php 
namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Functions\Functions;
use App\Payments;

class Orders extends Model {
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $table="orders";
    
    public static $status = ["" => "Select Status","7" => "Canceled","5" => "Delivered","10" => "Failed"
                            ,"1" => "Pending","15" => "Processed","2" => "Processing","11" => "Refunded"
                            ,"3" => "Shipped"];
    public static $colors = ["7" => "label label-sm label-danger","5" => "label label-sm label-success","10" => "label label-sm label-danger"
                            ,"1" => "label label-sm label-info","15" => "label label-sm label-info","2" => "label label-sm label-info","11" => "label label-sm label-danger"
                            ,"3" => "label label-sm label-info"];


    public function users() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function guests() {
        return $this->hasOne('App\Guests', 'order_id', 'id');
    }
    public static function search($search,$user_id='',$customerId='')
    {
        $sql = 'CASE WHEN (orders.user_id IS NULL OR orders.user_id = 0)
                THEN g.firstName
                ELSE u.firstName 
                END';
        $result = Orders::leftJoin("users as u","orders.user_id","=","u.id")
                  ->leftJoin("guests as g","orders.id","=","g.order_id")  
                  ->join("order_products as op","orders.id","=","op.order_id");
        if($user_id!=''){
            $result = $result->join("products as pro","pro.id","=","op.product_id");
        }
        $result = $result->select("orders.*","u.firstName","u.lastName",
                    "g.firstName as gFirstName","g.lastName as gLastName","op.vendorStatus")
                  ->selectRaw("SUM(op.quantity) as totalQuantity");
        
        if(isset($search['order_id']) && $search['order_id']!="") 
        {
            $result = $result->where('orders.id','=',$search['order_id']);
        }
        if((isset($search['date_from']) && $search['date_from']!="") && 
        (isset($search['date_to']) && $search['date_to']!="")) 
        {
            $from = date('Y-d-m' . ' 00:00:00',strtotime($search['date_from'])); //need a space after dates.
            $to = date('Y-d-m' . ' 23:59:59',strtotime($search['date_to']));
            $result = $result->whereBetween('orders.created_at',[$from,$to]);
                     
        }
        if(isset($search['customer']) && $search['customer']!="") 
        {
            $result = $result->whereRaw($sql.' LIKE  "%'.$search['customer'].'%"');
                      //->orWhere('u.lastName','LIKE',"%".$search['customer']."%"),u.lastName
        }
        if((isset($search['price_max']) && $search['price_max']!="") && 
        (isset($search['price_min']) && $search['price_min']!="")) 
        {
             $result = $result->whereBetween('orders.grandTotal',array($search['price_min'],$search['price_max']));
        } 
        if(isset($search['vendorStatus']) && $search['vendorStatus']!="") 
        {
            $result = $result->where('op.vendorStatus','=',$search['vendorStatus']);
        }
        if(isset($search['status']) && $search['status']!="") 
        {
            $result = $result->where('orders.status','=',$search['status']);
        }
        if($user_id!='')
        {
            $result= $result->where("pro.user_id","=",$user_id);
        }
        if($customerId!='')
        {
            $result= $result->where("orders.user_id","=",$customerId);
        }
        
        $result = $result->groupby("orders.id")->orderby("orders.id","desc")->paginate(10);
        return $result;
    }
    public static function getOrderById($id,$user_id='')
    {
        $result['order'] = Orders::where("orders.id", $id)
                ->leftJoin("users as u", "orders.user_id", "=", "u.id")
                ->leftJoin("regions as r", "u.region", "=", "r.id")
                ->leftJoin("cities as c", "u.city", "=", "c.id")
                ->leftJoin("orders_discounts as od", "od.order_id", "=", "orders.id")
                ->select("orders.*","od.discount", "u.firstName", "u.lastName", "r.name as regionName", "c.name as cityName", "u.mobile", "u.email", "u.address")
                ->first();

        $result['products'] = DB::table("order_products as op")->where("op.order_id", $id)
                        ->where('u.type', '=', 'product')
                        ->join("products as p", "p.id", "=", "op.product_id")
                        ->leftJoin("urls as u","op.product_id","=","u.type_id")
                        ->leftJoin("users as us","us.id","=","p.user_id")
                        ->leftJoin("categories as cat", "p.id", "=", "cat.id")
                        ->leftJoin("gallery_images as im", "im.product_id", "=", "p.id")
                        ->leftJoin("product_size as ps", "ps.id", "=", "op.productsize_id")
                        ->leftJoin("size as s", "s.id", "=", "ps.size_id")
                        ->select("p.name","p.sku","us.firstName", "op.*", "im.url","u.key as link", "s.name as size","ps.sku as childSku", "cat.name as category", "p.status")
                        ->where("im.sort_order", "=", 1);
        if($user_id!='')
        {
            $result['products']= $result['products']->where("p.user_id","=",$user_id);
        }
            $result['products']= $result['products']->groupby("op.id", "im.url", "op.productsize_id")
                        ->orderby("op.id", "desc")->get();

        return $result;
    }
    public static function getOrderDetailByPk($id)
    {
        $orders=DB::table('orders as o')
            ->where('o.id','=',$id)
            //->where('opa.value','!=','')
            ->leftJoin('shipping as s', 's.id', '=', 'o.shipping_id')
            ->leftJoin('orders_discounts as od', 'od.order_id', '=', 'o.id')
            ->leftJoin('orders_products as op', 'o.id', '=', 'op.order_id')
            ->leftJoin('products as p', 'p.id', '=', 'op.product_id')
            ->leftJoin('order_product_attributes as opa', 'opa.orders_prodrocts_id', '=', 'op.id')
            ->leftJoin('attributes as a', 'a.id', '=', 'opa.attribute_id')
            ->select('o.id as order_id','o.user_id as user_id','o.paymentStatus as paymentStatus','o.billingFirstName','o.billingLastName','o.shippingFirstName','o.shippingLastName','o.email','o.email','o.message','o.paymentType','o.orderStatus as orderStatus','o.created_at as orderDate','p.simpleProduct as simpleProduct','op.quantity as quantity','op.price as price','o.grandTotal as grandTotal','p.id as product_id','p.name as product_name','p.image as image',DB::raw('group_concat(opa.attribute_id) as attribute_id'),'s.name as shippingMethod','s.price as shippingPrice','od.discount as discount',DB::raw('group_concat(opa.value) as value'),DB::raw('group_concat(opa.value_id) as value_id'),DB::raw('group_concat(a.name) as attribute'))
            ->groupBy('op.id')
            ->get();
            //d($orders,1);
            $data=array();
            $i=0;
            foreach($orders as $order)
            {
               $data['id']=$id; 
               $data['user_id']=$order->user_id; 
               $data['name']=$order->billingFirstName.' '.$order->billingLastName;
               $data['billingName']=$order->billingFirstName.' '.$order->billingLastName;
               $data['shippingName']=$order->shippingFirstName.' '.$order->shippingLastName;
               $data['email']=$order->email; 
               $data['grandTotal']=$order->grandTotal; 
               $data['message']=$order->message;
               $data['orderDate']=$order->orderDate;
               $data['shippingMethod']=$order->shippingMethod;
               $data['discount']=$order->discount;
               
               $data['shippingPrice']=$order->shippingPrice;
               $data['orderStatus']=$order->orderStatus;
               $data['paymentStatus']=$order->paymentStatus;
               $data['paymentType']=$order->paymentType;
               $data['products'][$i]['id']=$order->product_id;
               $data['products'][$i]['id']=$order->product_id;
               
               $data['products'][$i]['name']=$order->product_name;
               $data['products'][$i]['image']=$order->image;
               $data['products'][$i]['quantity']=$order->quantity;
               $data['products'][$i]['price']=$order->price;
               $data['products'][$i]['simpleProduct']=$order->simpleProduct;
               $data['products'][$i]['attribute_id']=$order->attribute_id;
               $data['products'][$i]['attribute']=$order->attribute;
               $data['products'][$i]['value_id']=$order->value_id;
               $data['products'][$i]['value']=$order->value;
               $i++;
            }
            $data=json_decode(json_encode($data), FALSE);
            
            
       return $data;
    }
    public static function getSalesByMonth($user_id=''){

        $result = Orders::selectRaw("YEAR(orders.created_at) as year, MONTH(orders.created_at) as month, SUM(orders.grandTotal) as total")
                ;
        if($user_id!='')
        {
            $result = $result->join("order_products as op","orders.id","=","op.order_id")
                ->join("products as pro","pro.id","=","op.product_id")
                ->where("pro.user_id","=",$user_id);
        }
        $result = $result->where("orders.status","=",5)->whereYear("orders.created_at","=",date("Y"))
                ->groupBy(DB::raw('YEAR(orders.created_at),MONTH(orders.created_at)'))->get();
                
        return $result;
    }
    public static function getOrdersByMonth($user_id=''){

        $result = Orders::selectRaw("YEAR(orders.created_at) as year, MONTH(orders.created_at) as month, COUNT(DISTINCT orders.id) as count")
                ;
        if($user_id!='')
        {
            $result = $result->join("order_products as op", "orders.id", "=", "op.order_id")
                    ->join("products as pro", "pro.id", "=", "op.product_id")
                    ->where("pro.user_id", "=", $user_id);
        }
        $result = $result->whereYear("orders.created_at","=",date("Y"))
                ->groupBy(DB::raw('YEAR(orders.created_at),MONTH(orders.created_at)'))
                ->get();
                
        return $result;
    }
    public static function totalAmount($user_id='',$year) {

        $row = Orders::whereYear("orders.created_at","=",$year)
                ->join("order_products as op","orders.id","=","op.order_id")
                ->join("products as pro","pro.id","=","op.product_id")
                ->selectRaw("SUM(orders.grandTotal) as total");
        if($user_id!='')
        {
            $row = $row->where("pro.user_id","=",$user_id);
        }
        $row = $row->where("orders.status","=",5)->first();
        $result['sales'] = $row->total;
        
        $row = Orders::whereYear("orders.created_at","=",$year)
                ->join("order_products as op","orders.id","=","op.order_id")
                ->join("products as pro","pro.id","=","op.product_id")
                ->selectRaw("SUM(orders.grandTotal) as total");
        if($user_id!='')
        {
            $row = $row->where("pro.user_id","=",$user_id);
        }
        $row = $row->where("orders.status","!=",5)->first();
        $result['pending'] = $row->total;
                
        return $result;
    }
    public static function report($search='',$user_id='') {
        
        if($user_id=='') {
            $result = Orders::join("order_products as op","op.id","=",
                 DB::raw("(select id from order_products where order_products.order_id = orders.id order by created_at desc limit 1)"))
                ->join("products as pro","pro.id","=",                 
                 DB::raw("(select id from products where products.id = op.product_id order by created_at desc limit 1)"))
                ->join("users as u","pro.user_id","=","u.id")
                ->select("u.firstName","u.id")
                ->selectRaw("SUM(orders.grandTotal) as orderAmount");
        if(isset($search['user_id']) && $search['user_id']!='')
        {
            $result= $result->where("pro.user_id","=",$search['user_id']);
        }
            $result= $result->where('orders.status','=',5)
                ->groupBy('u.id')
                ->orderBy('orders.id','desc')
                ->paginate(15);
        }
        elseif($user_id!='') {
            $result['commission'] = Orders::where('pro.user_id', '=', $user_id)
                            ->join("order_products as op", "orders.id", "=", "op.order_id")
                            ->join("products as pro", "pro.id", "=", "op.product_id")
                            ->selectRaw("SUM(op.totalCommission) as totalCommission")
                            ->where('orders.status', '=', 5)->first();

            $result['payment'] = Payments::where('user_id', '=', $user_id)
                    ->selectRaw("SUM(amount) as payAmount")
                    ->first();
        }
        return $result;
        
    }

}
