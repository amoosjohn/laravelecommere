<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
	//
    protected $table='content';
    
    public static $types=[""=>"Select Type","page"=>"page","email"=>"email","block"=>"block"];
    public static function getPage($code) {
        $result = Content::where("code","=",$code)
                  ->where("type","=","page")
                  ->where("deleted","!=",1)
                  ->first();  
        return $result;
    }
    public static function getShipping() {
        $shipping_info  = Content::where('code', 'shipping-rates')->first();
        $shipping_rates = (count($shipping_info)>0)?$shipping_info->body:0; 
        return $shipping_rates;
    } 
    public static function getType($type) {
        $result = Content::where("type","=",$type)
                  ->where("deleted","!=",1)
                   ->orderBy("id","desc") 
                  ->get();  
        return $result;
    }
}
