<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
	//
    protected $table='cart';
    
    public static function countItems($sessionId)
    {
        $result = Cart::selectRaw("SUM(quantity) as totalCount")
                ->where("session_id","=",$sessionId)->first();
        $totalCount = $result->totalCount;
        return $totalCount;
    }
    public static function getCart($sessionId)
    {
        $result = Cart::join("products as pro","pro.id","=","cart.product_id")
               ->leftJoin("urls as u","pro.id","=","u.type_id")
               ->join('categories as cat','pro.category_id','=','cat.id')
               ->join("gallery_images as img","img.product_id","=","cart.product_id")
               ->leftJoin("product_size as ps","ps.id","=","cart.productsize_id")
               ->leftJoin("size as s","s.id","=","ps.size_id")
               ->select("pro.name","cart.*","img.url","s.name as size","cat.name as category","cat.commission","u.key")
               ->where("cart.session_id","=",$sessionId)
               ->where("img.sort_order","=",1)
               ->where('u.type', '=', 'product')
               ->groupby("cart.id","img.url","cart.productsize_id")
               ->orderby("cart.id","desc")->get(); 
        
        return $result;
    }
    public static function grandTotal($sessionId)
    {
        $result = Cart::selectRaw("SUM(totalPrice) as total")
                ->where("session_id","=",$sessionId)->first();
        $totalCount = $result->total;
        return $totalCount;
    }
}
