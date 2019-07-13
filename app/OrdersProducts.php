<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;
use App\ProductSize;
use App\Products;
use App\Functions\Functions;

class OrderProducts extends Model {
    
    
    public $table="order_products";
    public static function addProducts($sessionId,$id){
        $cart = Cart::getCart($sessionId);
        $data = array();
        foreach($cart as $row)
        {
            if (isset($row->commission)) {
                $commission = Functions::calculateCommission($row->commission, $row->totalPrice);
            }
            $cartQuan=$row->quantity;
            $product_id=$row->product_id;
            $productsize_id=$row->productsize_id;
            $data[] = ['order_id'=>$id,'product_id'=>$row->product_id,
                    'quantity'=>$cartQuan,'unitPrice'=>$row->unitPrice,
                    'totalPrice'=>$row->totalPrice,'productsize_id'=>$productsize_id,
                    'commission'=>$row->commission,'totalCommission'=>$commission,
                    'created_at'=>date('Y-m-d H:i:s')];

            $product = Products::find($product_id);
            $inputPro['quantity'] = $product->quantity - $cartQuan;
            Products::where('id',$product_id)->update($inputPro);
            if($productsize_id!=''){
                $productSize = ProductSize::find($productsize_id);
                $inputs['quantity'] = $productSize->quantity - $cartQuan;
                ProductSize::where('id',$productsize_id)->update($inputs);
            }

        }
        if(count($data)>0) {
            OrderProducts::insert($data);
            Cart::where('session_id','=',$sessionId)->delete();
        }
    }  
    public static function checkProducts($id){
        $result = OrderProducts::where("product_id","=",$id)->count();
        return $result;
    }

}
