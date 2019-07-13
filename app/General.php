<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categories;
use App\Brands;
use App\Slider;
use App\Sections;
use App\Reviews;
use Illuminate\Support\Facades\Cache;
use App\Functions\Functions;

class General extends Model {

    
    public static function getCategories($key=''){
                
        $result = Categories::where('categories.level', '=',1)
                  ->join("urls as u","categories.id","=","u.type_id")
                  ->select("categories.*","u.key")
                  ->where('u.type', '=', 'category');
        if($key!='')  {
            $result = $result->where('u.key','=',$key)->first(); 
        }      
        else {
            $result = $result->groupby("categories.id","u.key")->get(); 
           //$result = $result->get(); 
       }
        return $result;
        
    }
    public static function getSubCategories($parent_id,$ids='',$level=0){
                  // $start = microtime(true);
                  // $result = Cache::remember('parent_id_'.$parent_id,60, function() use ($parent_id,$ids,$level){

        $result = Categories::with("children");
        if($ids!=''){
            $result = $result->whereIn('categories.id',$ids);
        }
        else {
            $result = $result->where('categories.parent_id','=',$parent_id);
        }
        $result = $result->join("urls as u","categories.id","=","u.type_id")
        ->select("categories.*", "u.key")
        ->where('u.type', '=', 'category')
        ->groupby("categories.id","u.key");
        if($level==3) {
            //$result = $result->limit(4); 
        }
        $result = $result->get(); 
        return $result;
         // } );
          
          
        //$duration = (microtime(true) - $start) * 1000;
       //\Log::info('my_logss:  '.$duration);
        return $result;
        
    }
    public static function getBrands($type){
                
        $result = Brands::join("urls as u","brands.id","=","u.type_id")
                  ->select("brands.*","u.key")
                  ->where('brands.status','=',1)
                  ->where($type, '=', 1)
                  ->where('u.type', '=', 'brand')
                  ->groupBy("brands.id","u.key")
                  ->orderBy("brands.id","desc")
                  ->limit(15)->get(); 
       
        return $result;
        
    }
    public static function getSliderImages() {
        
        $result = Slider::where("status","=",1)
                  ->where("type","=",1)->orderBy("id","desc")
                  ->limit(8)->get();
        
        return $result;           
    }
    public static function getSliderImage($type,$category_id='') {
        
        $result = Slider::where("status","=",1)
                  ->where("type","=",$type);
        if($category_id!='')
        {
            $result = $result->where("category_id","=",$category_id)
                    ->orderBy("id","desc")->limit(8)
                    ->get();
        }
        else {
            $result =  $result->orderBy("id","desc")
                  ->first();
        }
        
        
        return $result;           
    }
    public static function getSection($type) {
        
        $result['section'] = Sections::where("sections.status","=",1)
                  ->where("sections.type","=",$type)
                  ->join("categories as cat","cat.id","=","sections.category")
                  ->join("urls as u","cat.id","=","u.type_id")
                  ->select("sections.*","cat.name as categoryName","cat.teaser as categoryIcon")  
                  ->orderBy("sections.id","desc")
                  ->first();
        if(count($result['section'])>0){
            $getCategory2 = explode(",", $result['section']->category2);
            $ids = array_map('intval', $getCategory2);
            $result['category2'] = General::getSubCategories(0,$ids);
            
            $getCategory3 = explode(",", $result['section']->category3);
            $result['category3'] = array_map('intval', $getCategory3);
        }
        
        
        return $result;           
    }
    public static function ratingNumber($id,$rate){
       $result = Reviews::where("product_id","=",$id)->where("status","=",1)
                ->where("ratings","=",$rate)
                //->selectRaw("SUM(ratings) as ratingSum")
                ->selectRaw("COUNT(ratings) as ratingCount")
                ->first();
       return $result;
    }
    
    public static function getCategoryBrands($id){
                
        $result = Brands::where('brands.status', '=', 1)->where('parent.id', '=', $id)
                 ->leftJoin("products as pro","pro.brand_id","=","brands.id")
                 ->join("categories as cat", "pro.category_id", "=", "cat.id")
                 ->leftJoin("categories as subcat", "subcat.id", "=", "cat.parent_id")
                 ->leftJoin("categories as parent", "parent.id", "=", "subcat.parent_id")
                 ->join("urls as u","brands.id","=","u.type_id")
                ->select("brands.*","u.key")
                ->where('u.type', '=', 'brand')
                ->groupBy("brands.id","u.key")
                ->orderBy("brands.id","desc")
                ->limit(24)->get(); 
       
        return $result;
        
    }
    public static function getBrand($key){
        $result = Brands::join("urls as u","brands.id","=","u.type_id");
                if(is_numeric($key)) {
                    $result = $result->where('brands.id','=',$key);
                }
                else {
                    $result = $result->where('u.key','=',$key);
                }
        $result = $result->select("brands.*","u.key")
               ->where('brands.status','=',1)
               ->where('u.type','=','brand')->first();
        return $result;
    }
    public static function getVendor($key){
        $result = User::join("urls as u","users.id","=","u.type_id");
                if(is_numeric($key)) {
                    $result = $result->where('users.id','=',$key);
                }
                else {
                    $result = $result->where('u.key','=',$key);
                }
        $result = $result->select("users.*","u.key")
               ->where('users.status','=',1) 
               ->where('u.type','=','vendor')->first();
        return $result;
    }
    public static function relatedProducts($id,$category_id=0){
        
        $result = Products::with("brands")
                 ->where("products.id","!=",$id)
                 ->where([
                   ['products.category_id', '=',$category_id],
                   ['products.status', '=',1],
                   ['u.type', '=', 'product'],
                   ['us.status', '=',1],
                   ])   
                 ->join("users as us","products.user_id","=","us.id")
                 ->join('urls as u','products.id','=','u.type_id')
                 ->select('products.*','u.key as link');

        $result = $result->orderBy("products.id","desc")->groupBy("products.id")->limit(12)->get();
        return $result;
        //        if($category_id!=0)
//        {
//            $result = $result->where("products.category_id","=",$category_id);
//        }
        
    }
    
    

}
