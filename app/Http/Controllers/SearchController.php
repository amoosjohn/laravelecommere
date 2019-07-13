<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect,Config;
use DB;
use Auth;
use App\Categories;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use App\Products;
use App\GalleryImage;
use App\User;
use App\Gallery;
use App\Colours;
use App\ProductSize;
use App\Brands;

class SearchController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
           $q = $request->q;
           $model = Products::searchQuery($q); 
           $currency = Config::get("params.currencies");
           $symbol = $currency["PKR"]["symbol"];
           return view('front.search.ajax.list', compact('model', 'symbol','q'));
        }
        
    }
    public function submit(Request $request)
    {
        $search['query'] = $request->q;
        $model = Products::searchProducts($search); 
        if(count($model)>0) {
            $categories = Categories::getParentCategories($search);
            $brands = Brands::getBrands($search);
            $colours = Colours::getColours($search);
            $sizes = ProductSize::getProductSize($search);

            $getPrice = Products::getMaxPrice($search);
            $maxPrice = $getPrice->maxPrice;
            $query = ($request->getQueryString() != '') ? '?' . $request->getQueryString() : '';
            $currency = Config::get("params.currencies");
            $symbol = $currency["PKR"]["symbol"];
            $pageTitle = $search['query'];

            return view('front.search.index', compact('model','pageTitle', 'query', 'symbol', 'maxPrice', 'categories', 'q', 'brands', 'colours', 'sizes'));
        }
        else {
            $pageTitle = 'Result not found!';
            $query = $request->q;
            return view('front.search.notfound', compact('pageTitle','model','query'));

        }
        
    }
    public function result(Request $request)
    {
        if($request->ajax())
        {
           $search = $request->all();
           $search['query'] = $request->q;
           if(isset($search['category'])){
           $category = Categories::where('id','=',$search['category'])->first();
            if ($category->level == 1) {
                $parent_id = $category->id;
                $childCat = Categories::getChildCategories($parent_id, 1, 1);
                $search['category'] = $childCat;
                $searchQuery = '&category=' . $parent_id;
            } elseif ($category->level == 2) {
                $parent_id = $category->id;
                $childCat = Categories::getChildCategories($parent_id, 1);
                $search['category'] = $childCat;
                $searchQuery = '&category=' . $parent_id;
            }
           }
           $model = Products::searchProducts($search); 
           $currency = Config::get("params.currencies");
           $symbol = $currency["PKR"]["symbol"];
           return response()->json(['total' => $model->total(),
               'view'=> view('front.products.listing', compact('model','symbol'))->render()
           ]);
        }
        
    }
    
    
}
