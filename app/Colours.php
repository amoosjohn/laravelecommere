<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
//use DB;

class Colours extends Model {

    protected $dates = ['deleted_at'];
    
    protected $table = 'colours';
    
    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }
    public static $status=[""=>"Select Status","1"=>"Active","0"=>"Deactive"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red-thunderbird"];
    
    public static function getColours($search=''){
        
        $result = Colours::join("products as pro","pro.colour_id","=","colours.id")
                  ->join("users as us","pro.user_id","=","us.id")
                  ->select("colours.*")->selectRaw("COUNT(pro.id) AS countColourProduct");
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
                        ['colours.status','=',1],
                        ['us.status','=',1]
                        ])->groupby("colours.id")->get(); 
       
        return $result;
        
    }

    
}
