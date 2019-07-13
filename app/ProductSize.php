<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'product_size';
   
    public static function getProductSize($search=''){
        
        $result = ProductSize::join("size as s","s.id","=","product_size.size_id")
                  ->join("products as pro","pro.id","=","product_size.product_id")  
                  ->join("users as us","pro.user_id","=","us.id")
                  ->select("s.*")->selectRaw("COUNT(product_size.product_id) AS countProductSize");
        if($search!='')
        {
            $result = $result->where('pro.name','LIKE',"%".$search['query']."%");
            if(isset($search['category']) && $search['category']!="") 
            {
                if(is_array($search['category'])){
                    $result = $result->whereIn('pro.category_id',$search['category']);
                }
                else {
                   $result = $result->where('pro.category_id','=',$search['category']);  
                }
            }
            if(isset($search['brand_id']) && $search['brand_id']!="") 
            {
                $result = $result->where('pro.brand_id','=',$search['brand_id']);
            }
            if(isset($search['vendor']) && $search['vendor']!="") 
            {
                $result = $result->where('pro.user_id','=',$search['vendor']);
            }
        }
        $result = $result->whereNull('pro.deleted_at')->where([
                        ['pro.status', '=',1],
                        ['us.status','=',1]
                        ])->groupby("product_size.size_id")->get(); 
       
        return $result;
        
    }
    public static function productSizes($id){
        $result = ProductSize::select("s.name","product_size.id","product_size.quantity")
                  ->join("size as s","s.id","=","product_size.size_id")
                  ->where("product_size.product_id","=",$id)->get();
        return $result;
    }
    public static function addProductSizes($input,$id){
        $sizes = $input['sizes'];
        $quantity = $input['quantity'];
        $productsize_id = $input['productsize_id'];
        $childSku = $input['childSku'];

        $data = array();
        $i = 0;
        foreach ($sizes as $size_id) {
            $input_size['quantity'] = $quantity[$i];
            $input_size['size_id'] = $size_id;
            $input_size['sku'] = $childSku[$i];
            $inputs['productsize_id'] = $productsize_id[$i];

            if ($size_id != '') {
                if ($inputs['productsize_id'] != 0) {
                    ProductSize::where('id', '=', $inputs['productsize_id'])->update($input_size);
                } else {
                    $data[] = array('product_id' => $id, 'size_id' => $input_size['size_id'],
                        'sku' => $input_size['sku'], 'quantity' => $input_size['quantity'], 'created_at' => date('Y-m-d H:i:s'));
                }
            }

            $i++;
        }
        if (count($data) > 0) {

            ProductSize::insert($data);
        }
    }

}
