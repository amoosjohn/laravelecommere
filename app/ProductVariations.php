<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ProductVariations extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'product_variations';
    
    public static function getVariations($id)
    {
        $result = DB::table("product_variations as var")
                    ->join("products as pro","pro.id","=","var.productvariation_id")
                    ->join("urls as u","pro.id","=","u.type_id")
                    ->join('gallery_images as img','pro.id','=','img.product_id')
                    ->select("pro.name","u.key as link","img.url")
                    ->where("var.product_id","=",$id)
                    ->whereNull("pro.deleted_at")
                    ->where([
                    ['pro.status', '=',1],
                    ['u.type', '=', 'product'],
                    ['img.sort_order','=',1]
                    ])
                    ->groupby("var.productvariation_id","u.key","img.url")
                    ->get();
        return $result;
    }
   
    
}
