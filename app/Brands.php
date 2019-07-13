<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use DB;

class Brands extends Model {

    protected $dates = ['deleted_at'];
    
    protected $table = 'brands';
    
    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }
    public static $status=[""=>"Select Status","1"=>"Active","0"=>"Deactive"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red-thunderbird"];
    
    public static function getBrands($search=''){
        
        $result = Brands::join("products as pro","pro.brand_id","=","brands.id")
                  ->join('urls as u','brands.id','=','u.type_id')
                  ->join("users as us","pro.user_id","=","us.id")  
                  ->select("brands.*","u.key")->selectRaw("COUNT(pro.id) AS countBrandProduct");
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
        if(isset($search['limit']) && $search['limit']!="") 
        {
           $result = $result->limit($search['limit']);
        }
        $result = $result->whereNull('pro.deleted_at')->where([
                        ['u.type','=','brand'],
                        ['pro.status', '=',1],
                        ['brands.status','=',1],
                        ['us.status','=',1],
                        ])->groupby("brands.id","u.key")->get(); 
       
        return $result;
        
    }
    public static function search($search='')
    {
        $result = Brands::with("users")
                ->join("urls as u","brands.id","=","u.type_id")        
                ->select("brands.*","u.key");
        if (isset($search['name']) && $search['name'] != "") {
            $name = $search['name'];
            $result = $result->where('brands.name', 'LIKE', "%" . $name . "%");
        } 
        if(isset($search['status']) && $search['status']!="") 
        {
            $result = $result->where('brands.status','=',$search['status']);
        }
        if(isset($search['user_id']) && $search['user_id']!="") 
        {
            $result = $result->where('brands.user_id','=',$search['user_id']);
        }
        $result = $result->where("u.type","=","brand")
                ->orderBy("brands.id","desc")
                ->groupBy("brands.id")
                ->paginate(10);
        
        return $result;
    }

}
