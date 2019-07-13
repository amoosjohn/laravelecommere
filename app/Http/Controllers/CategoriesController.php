<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect,Config;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Categories;
use App\Urls;
use App\Functions\Functions;
use App\Colours;
use App\ProductSize;
use App\Brands;
use App\Products;
use App\User;
use App\General;

class CategoriesController extends Controller {

   
    public function index(Request $request,$key) {
        
        $category = General::getCategories($key);//$category->level==1
        $id = $category->id;
        $subCategories = General::getSubCategories($id);
        $categoryBrands = General::getCategoryBrands($id);
        $search['categories'] = $id;
        $search['limit'] = 20;       
        $related_products = array();//Products::searchProducts($search);
        $sliderImages = General::getSliderImage(6,$id);
        $searchQuery = '&category='.$search['categories'];
        $pageTitle = $category->name;  
        $search['query'] = '';
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        
        return view('front.categories.index', compact('model','pageTitle','sliderImages','related_products','categoryBrands','subCategories','searchQuery','category','query','symbol','maxPrice','categories','brands','colours','sizes'));
    }
    public function category(Request $request,$key) {
        
        $category = Categories::join("urls as u","categories.id","=","u.type_id")
               ->select("categories.*")
               ->where('u.type','=','category')
               ->where('u.key','=',$key)->first();//$category->level==1
        if($category->level==1) {
            $parent_id = $category->id;
            $childCat = Categories::getChildCategories($parent_id,1,1);
            $search['category'] = $childCat;
            $searchQuery = '&category='.$parent_id;
        }
        elseif($category->level==2) {
            $parent_id = $category->id;
            $childCat = Categories::getChildCategories($parent_id,1);
            $search['category'] = $childCat;
            $searchQuery = '&category='.$parent_id;
        }
        else {
            $search['category'] = $category->id;
            $searchQuery = '&category='.$search['category'];
        }    
        $search['query'] = isset($request->q)?$request->q:'';
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $model = Products::searchProducts($search); 
        $categories = Categories::getParentCategories($search);
        $brands = Brands::getBrands($search);
        $colours = Colours::getColours($search);
        $sizes = ProductSize::getProductSize($search);
        $getPrice = Products::getMaxPrice($search);
        $maxPrice = $getPrice->maxPrice;
        $query = ($request->getQueryString()!='')?$request->getQueryString():'';
        $pageTitle = $category->name;
            
        return view('front.categories.category', compact('model','pageTitle','searchQuery','category','query','symbol','maxPrice','categories','brands','colours','sizes'));
    }

    public function brand(Request $request,$key) {

        $brand = General::getBrand($key);
        if(count($brand)==0) {
            abort(404);
        }
        $brand_id = $brand->id;
        $search['query'] = isset($request->q)?$request->q:'';
        $search['brand_id'] = $brand_id;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $model = Products::searchProducts($search); 
       
        $categories = Categories::getParentCategories($search);
        $brands = Brands::getBrands($search);
        $colours = Colours::getColours($search);
        $sizes = ProductSize::getProductSize($search);
        
        $getPrice = Products::getMaxPrice($search);
        $maxPrice = $getPrice->maxPrice;
        $query = ($request->getQueryString()!='')?$request->getQueryString():'';
        $searchQuery = '&brand_id='.$search['brand_id'];
        $pageTitle = $brand->name;
            
        return view('front.brands.index', compact('model','pageTitle','searchQuery','brand_id','brand','query','symbol','maxPrice','categories','brands','colours','sizes'));
    }
    public function vendor(Request $request,$key) {

        $users = General::getVendor($key);
        if(count($users)==0) {
            abort(404);
        }
        $search['query'] = isset($request->q)?$request->q:'';
        $search['vendor'] = $users->id;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $model = Products::searchProducts($search); 
       
        $categories = Categories::getParentCategories($search);
        $brands = Brands::getBrands($search);
        $colours = Colours::getColours($search);
        $sizes = ProductSize::getProductSize($search);
        
        $getPrice = Products::getMaxPrice($search);
        $maxPrice = $getPrice->maxPrice;
        $query = ($request->getQueryString()!='')?$request->getQueryString():'';
        $searchQuery = '&vendor='.$search['vendor'];
        $pageTitle = $users->firstName;
            
        return view('front.products.vendor', compact('model','pageTitle','searchQuery','users','query','symbol','maxPrice','categories','brands','colours','sizes'));
    }

}
