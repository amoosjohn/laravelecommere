<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Functions\Functions;
use DB;

class Products extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'products';
    
    public static $status = ["" => "Select Status", "1" => "Enable", "0" => "Disable", "2" => "Out of stock"];
    public static $colors = ["1" => "label label-sm label-success", "0" => "label label-sm label-danger", "2" => "label label-sm label-info"];
    public static $stock_status = ["" => "Select Stock Status", "1" => "In Stock",  "2" => "Out Of Stock","3" => "2-3 Days"];

    public function users() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function brands() {
        return $this->hasOne('App\Brands', 'id', 'brand_id');
    }
    public function urls() {
        return $this->hasOne('App\Urls', 'type_id', 'id')->where('type', '=', 'product');
    }
    public function gallery_images() {
        return $this->hasOne('App\GalleryImage', 'product_id', 'id')->where('sort_order', '=', 1);
    }
    public function colours() {
        return $this->hasOne('App\Colours', 'id', 'colour_id');
    }
    public static function search($search,$user_id='',$paginate='')
    {
        $sql = 'CASE WHEN (products.sale_price IS NULL OR products.sale_price = 0)
                THEN products.price
                ELSE products.sale_price 
                END';
        $result = Products::with("users")->with("brands")->with("colours")
                ->join('urls as u','products.id','=','u.type_id')
                ->join("categories as cat","products.category_id","=","cat.id")
                ->leftJoin("categories as subcat","subcat.id","=","cat.parent_id")
                ->leftJoin("categories as parent","parent.id","=","subcat.parent_id")
                ->select("products.*","cat.name as categoryName"
                        ,"parent.name as parentCategoryName","subcat.name as subCategoryName"
                        ,"cat.commission as categoryCommission","u.key as link");   
        
        if(isset($search['product_id']) && $search['product_id']!="") 
        {
            $result = $result->where('products.id','=',$search['product_id']);
        }
        if(isset($search['product_name']) && $search['product_name']!="") 
        {
            $result = $result->where('products.name','LIKE',"%".$search['product_name']."%");
        }
        if(isset($search['category_id']) && $search['category_id']!="") 
        {
            $result = $result->where('products.category_id','=',$search['category_id']);
        }
        if(isset($search['brand_id']) && $search['brand_id']!="") 
        {
            $result = $result->where('products.brand_id','=',$search['brand_id']);
        }
        if((isset($search['price_max']) && $search['price_max']!="") && 
        (isset($search['price_min']) && $search['price_min']!="")) 
        {
            $price_from = $search['price_min'];
            $price_to = $search['price_max'];
            $result = $result->whereRaw($sql.' BETWEEN '.$price_from.' AND '.$price_to.'');
        }
        if(isset($search['created_by']) && $search['created_by']!="") 
        {
            $result = $result->where('products.user_id','=',$search['created_by']);
        }
        if(isset($search['status']) && $search['status']!="") 
        {
            $result = $result->where('products.status','=',$search['status']);
        }
        if(isset($search['popular']) && $search['popular']!="") 
        {
            $result = $result->where('products.popular','=',$search['popular']);
        }
        $result= $result->where('u.type', '=', 'product');
        if($user_id!='')
        {
            $result= $result->where("products.user_id","=",$user_id);
        }
        if($paginate==1) {
            $result = $result->orderBy("products.id", "desc")
                ->groupBy("products.id")
                ->get();
        }
        else {
            $length = 10;
            if(isset($search['length']) && $search['length']!="") 
            {
                $length = $search['length'];
            }
            $result = $result->orderBy("products.id", "desc")
                ->groupBy("products.id")
                ->paginate($length);
        }
               
        return $result;       
    }
    public static function getProductById($id){
        
        $result = Products::where("u.key","=",$id)
                ->where("products.status","=",1)
                ->where('u.type', '=', 'product')
                ->where("us.status","=",1)
                ->join("users as us","products.user_id","=","us.id")
                ->leftJoin("cities as cs","us.city","=","cs.id")
                ->join("urls as u","products.id","=","u.type_id")
                ->join("categories as cat","products.category_id","=","cat.id")
                ->leftJoin('brands as bran', function ($join) {
                    $join->on("products.brand_id","=","bran.id")
                    ->where('bran.status', '=', 1);
                })
                //->leftJoin("brands as bran","products.brand_id","=","bran.id")
                ->select("products.*","cat.name as categoryName","bran.name as brandName"
                        ,"bran.image as brandImage","u.key as link",
                        "us.firstName","cs.name as cityName")
                //->ORwhere('bran.status',  1)
                //->ORwhere('bran.status',  NULL)
                ->first();
        return $result;
        
    }
    public static function getMaxPrice($search=''){
        $sql = 'CASE WHEN (products.sale_price IS NULL OR products.sale_price = 0)
                THEN products.price
                ELSE products.sale_price 
                END';
        $result = Products::selectRaw("MAX($sql) AS maxPrice");
        if($search!='')
        {
            $result = $result->where('name','LIKE',"%".$search['query']."%");
            if(isset($search['category']) && $search['category']!="") 
            {
                if(is_array($search['category'])){
                    $result = $result->whereIn('products.category_id',$search['category']);
                }
                else {
                   $result = $result->where('products.category_id','=',$search['category']);  
                }
            }
            if(isset($search['brand_id']) && $search['brand_id']!="") 
            {
                $result = $result->where('products.brand_id','=',$search['brand_id']);
            }
            if(isset($search['vendor']) && $search['vendor']!="") 
            {
                $result = $result->where('products.user_id','=',$search['vendor']);
            }
        }
        $result = $result->where('status', '=',1)->first();
        
        return $result;
    }
    public static function searchProducts($search='')
    {
        $sql = 'CASE WHEN (products.sale_price IS NULL OR products.sale_price = 0)
                THEN products.price
                ELSE products.sale_price 
                END';
        $result = Products::join('urls as u','products.id','=','u.type_id')
                ->join("users as us","products.user_id","=","us.id")
                ->join('categories as cat','products.category_id','=','cat.id')
                ->join('gallery_images as images','images.product_id','=','products.id')
                ->leftJoin('brands as bran','products.brand_id','=','bran.id')
                ->leftJoin('reviews as r','products.id','=','r.product_id');
        
        if(isset($search['colour']) && $search['colour']!="") 
        {
            $result = $result->leftJoin('colours as col','products.colour_id','=','col.id');
        }
        if(isset($search['size']) && $search['size']!="") 
        {
            $result = $result->leftJoin('product_size as s','products.id','=','s.product_id');
        }
        if(isset($search['categories']) && $search['categories']!="") 
        {
            $result = $result->join("categories as subcat", "subcat.id", "=", "cat.parent_id")
                ->join("categories as parent", "parent.id", "=", "subcat.parent_id")
                ->where("parent.id","=",$search['categories']);
        }
        if(isset($search['counter']) && $search['counter']!="") {
            $result = $result->join("product_counter as co","co.product_id","=","products.id");
        }
        $result = $result->select('products.*','images.url','cat.name as categoryName',
                        "bran.name as brandName",'u.key as link')
                ->selectRaw('COUNT(r.ratings) as ratingCount')->selectRaw('SUM(r.ratings) as ratingSum');
        
       $result = $result->where([
                   ['products.status', '=',1],
                   ['u.type', '=', 'product'],
                   ['images.sort_order','=',1],
                   ['us.status', '=',1],
                   ]);
        if(isset($search['query']) && $search['query']!="") 
        {
            $result = $result->where('products.name','LIKE',"%".$search['query']."%");
        }
        if(isset($search['brand']) && $search['brand']!="") 
        {
            $brands = Functions::getArray($search['brand']);
            $result = $result->whereIn('products.brand_id',$brands);
        }
        if(isset($search['colour']) && $search['colour']!="") 
        {
            $colours = Functions::getArray($search['colour']);
            $result = $result->whereIn('products.colour_id',$colours);
        }
        if(isset($search['size']) && $search['size']!="") 
        {
            $size = Functions::getArray($search['size']);
            $result = $result->whereIn('s.size_id',$size);
        }
        if((isset($search['price_from']) && $search['price_from']!="") && 
        (isset($search['price_to']) && $search['price_to']!="")) 
        {
            //sale_price
            //$result = $result->whereBetween('products.price',array($search['price_from'],$search['price_to']));
            $price_from = $search['price_from'];
            $price_to = $search['price_to'];
            $result = $result->whereRaw($sql.' BETWEEN '.$price_from.' AND '.$price_to.'');
        }
        if(isset($search['category']) && $search['category']!="") 
        {
            if(is_array($search['category'])){
               $result = $result->whereIn('products.category_id',$search['category']);
            }
            else {
                $result = $result->where('products.category_id','=',$search['category']);
            }
            
        }
        if(isset($search['brand_id']) && $search['brand_id']!="") 
        {
            $result = $result->where('products.brand_id','=',$search['brand_id']);
        }
        if(isset($search['vendor']) && $search['vendor']!="") 
        {
            $result = $result->where('products.user_id','=',$search['vendor']);
        }
        
        
        
        if(isset($search['sort']) && $search['sort']!="") 
        {
            $sort = $search['sort'];
            if($sort=='newest')
            {
                $result = $result->orderby('products.id','desc');
            }
            if($sort=='lowest_price')
            {
                //$result = $result->orderBy('products.sale_price','asc');
                 $result = $result->orderbyRaw($sql.' ASC');
            }
            if($sort=='highest_price')
            {
                //$result = $result->orderBy('products.sale_price','desc');
                $result = $result->orderbyRaw($sql.' DESC');
            } 
            if($sort=='rating')
            {
                $result = $result->orderByRaw('ratingCount desc');
            }
            if($sort=='popularity')
            {
                $result = $result->orderBy('products.popular','desc');
                $result = $result->orderByRaw('-products.sortOrder DESC');
            }
        }
        else {
            //$result = $result->orderby('products.id','desc');
            if(isset($search['counter']) && $search['counter']!="") {
            $result = $result->orderByRaw("COUNT(co.product_id) desc");
            }
            else {
                $result = $result->orderByRaw('-products.sortOrder DESC');
                        //orderBy('products.sortOrder','asc');//->orderBy('products.popular','desc')
            }
        }
        if(isset($search['review']) && $search['review']!="") 
        {
            $result = $result->havingRaw('SUM(r.ratings)  >= '.$search['review']);
        }
        
        if(isset($search['productId']) && $search['productId']!="") 
        {
            // Related Products Result
            $result = $result->where("products.id","!=",$search['productId']);
        }
        
        // Search Result
        $limit = 21;
        if(isset($search['limit']) && $search['limit']!="") 
        {
            // Related Products Result
            $limit = $search['limit'];
        }
        
        /*if(isset($search['size']) && $search['size']!="") 
        {
            $result = $result->groupby('s.product_id')->paginate(12);
        }
        else
        {*/
            $result = $result->groupby("products.id","u.key")->paginate($limit);//
        //}
        return $result;
    }
    public static function searchQuery($query) {
        $search['limit'] = 3;
        $search['query'] = $query;
        $result['products'] = Products::where([
                   ['products.status', '=',1],
                   ['products.name','LIKE',"%".$query."%"],
                   ['u.type', '=', 'product'],
                   ['images.sort_order','=',1],
                   ['us.status', '=',1],
                   ])
                ->join('urls as u','products.id','=','u.type_id')
                ->join("users as us","products.user_id","=","us.id")
                ->join('categories as cat','products.category_id','=','cat.id')
                ->join('gallery_images as images','images.product_id','=','products.id')
                ->select('products.name','products.name','products.price'
                        ,'products.sale_price','images.url','u.key as link')
                ->orderByRaw('-products.sortOrder DESC')
                ->groupby("products.id","u.key")->paginate($search['limit']);
        
        $result['brands'] = Brands::getBrands($search);
        
        $result['category'] = Categories::join('products','products.category_id','=','categories.id')
                    ->join('urls as u','categories.id','=','u.type_id')
                    ->select('categories.*','u.key')
                    ->where('products.name','LIKE',"%".$query."%")
                    ->where('products.status','=',1)
                    ->where('categories.level', '=', 2)
                    ->where('u.type', '=', 'category')->groupBy('categories.id')->limit(3)->get();
        return $result;
    }

}
