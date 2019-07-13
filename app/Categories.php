<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use DB;

class Categories extends Model {

    protected $table = 'categories';
    public static function getCategories()
    {
        $result = Categories::leftJoin("categories as subcat","subcat.id","=","categories.parent_id")
                ->leftJoin("categories as parentcat","parentcat.id","=","subcat.parent_id")
                ->select("categories.*","subcat.name as categoryName","parentcat.name as parentName")
                ->orderby("name","asc")->get();
        return $result;
    }

    public function parent()
    {
        return $this->belongsTo('App\Categories', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Categories', 'parent_id','id');
    }
    public static function getParentCategories($search=''){
        
        $result = Categories::where('pro.status', '=',1)
                  ->join("products as pro","pro.category_id","=","categories.id")
                  ->join("users as us","pro.user_id","=","us.id")
                  ->join("categories as subcat","subcat.id","=","categories.parent_id")
                  ->join("categories as parent","parent.id","=","subcat.parent_id")                
                  ->join("urls as u","parent.id","=","u.type_id")
                  ->select("parent.name as parentName","u.key as link")
                  ->selectRaw("COUNT(pro.id) AS countCatProduct");
       
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
        else {
            $result = $result->limit(15);
        }
        $result = $result->whereNull('pro.deleted_at')->where([
                        ['u.type', '=', 'category'],
                        ['pro.status', '=',1],
                        ['us.status','=',1]
                        ])->groupby("parent.id","u.key")->get(); 
        //dd($result);
        return $result;
        
    }
    public static function getChildCategories($parent_id,$getId=0,$level=3)
    {
        if($level==3) {
            $result = Categories::where("parent_id","=",$parent_id)->where("level","=",3)
                  ->get()->toArray();
        }
        elseif($level==2 || $level==1) {
            $result = Categories::join("categories as subcat","subcat.parent_id","=","categories.id")
                    ->join("categories as parentcat","parentcat.parent_id","=","subcat.id")
                    ->select("parentcat.*")
                    ->where("parentcat.level","=",3)
                    ->where("subcat.parent_id","=",$parent_id)
                    ->groupBy("parentcat.id")
                    ->get()->toArray();
        }
        
        
        if($getId==1) {
            
            $dataIds = array_map(function($result) {
                    return $result['id'];
                }, $result);
            return $dataIds;    
        }
        else {
            return $result;
        }
        
    }
    public static function getAllCategories($id) {
        $result = Categories::where("categories.id","=",$id)
                ->where('u.type', '=', 'category')
                ->where('usubcat.type', '=', 'category')
                ->where('uparentcat.type', '=', 'category')
                ->join("urls as u","categories.id","=","u.type_id")
                ->leftJoin("categories as subcat","subcat.id","=","categories.parent_id")
                ->leftJoin("urls as usubcat","subcat.id","=","usubcat.type_id")
                ->leftJoin("categories as parentcat","parentcat.id","=","subcat.parent_id")
                ->leftJoin("urls as uparentcat","parentcat.id","=","uparentcat.type_id")
                ->select("categories.*","u.key as categoryUrl",
                        "subcat.name as categoryName","parentcat.name as parentName",
                        "usubcat.key as subCategoryUrl","uparentcat.key as parentCategoryUrl")
                ->groupBy("categories.id","subcat.id","parentcat.id")->first();
        return $result;
    }

}
