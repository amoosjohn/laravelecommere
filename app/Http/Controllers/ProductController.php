<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect,Config;
use DB;
use Auth;
use App\Categories;
use App\Brands;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use App\Products;
use App\Colours;
use App\GalleryImage;
use App\User;
use App\Gallery;
use App\ProductSize;
use App\ProductVariations;
use App\Reviews;
use App\ProductCounter;
use App\General;

class ProductController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $id = $request->id;
        $product = Products::getProductById($id);
        
        if(count($product)>0)
        {
            $size = $request->size;
            $id = $product->id;
            $pageTitle = $product->name;
        
//            $search['category'] = $product->category_id;
//            $search['productId'] = $id;
//            $search['limit'] = 12;
            $related_products = General::relatedProducts($id,$product->category_id);//Products::searchProducts($search)
            //$viewed_products = array();//Products::searchProducts($search);
            $gallery_images = GalleryImage::where("product_id", "=", $id)->orderby("sort_order", "asc")->get();
            $product_sizes = ProductSize::productSizes($id);
            //$productVar = ProductVariations::getVariations($id);
            $title = $product->meta_title;
            $keyword = $product->meta_keyword;
            $description = $product->meta_description;
            $currency = Config::get("params.currencies");
            $symbol = $currency["PKR"]["symbol"];
            $brandUrl = General::getBrand($product->brand_id);
            $vendorUrl = General::getVendor($product->user_id);
            
            $reviews = Reviews::getReviews($id);
            $ratings = Reviews::getTotalRatings($id);
            $ratingCount =$ratings['ratingCount'];
            $avgRating = $ratings['avgRating'];
            $ip = $request->ip();
            ProductCounter::addCounter($ip,$id);
            $breadcrumb[0]['name'] = 'Home';
            $breadcrumb[0]['link'] = url('/');
            $category = Categories::getAllCategories($product->category_id);
            if(count($category)>0){
                $breadcrumb[1]['name'] = $category->parentName;
                $breadcrumb[1]['link'] = url('main/' . $category->parentCategoryUrl);
                $breadcrumb[2]['name'] = $category->categoryName;
                $breadcrumb[2]['link'] = url('category/' . $category->subCategoryUrl);
                $breadcrumb[3]['name'] = $category->name;
                $breadcrumb[3]['link'] = url('category/' . $category->categoryUrl);
            }
            $breadcrumb[4]['name'] = $product->name;
            $breadcrumb[4]['link'] = url('product/' . $product->link);
        }
        
        return view('front.products.details', compact('product','breadcrumb','pageTitle','id','avgRating','ratingCount','reviews','vendorUrl','size','brandUrl','symbol','productVar','title','keyword','description','product_sizes','gallery_images','related_products','viewed_products'));
    }
    public function review(Request $request,$key)
    {
        if(isset($key) && !empty($key)) {
            $product = Products::getProductById($key);
            if(count($product)>0)
            {
                $pageTitle = 'Review this Product';
                return view('front.review',compact('product','pageTitle','key'));
            }
            else {
                return redirect('/');
            }
        }
    }
    public function store(Request $request,$key) {
        $validation = array(
            'title' => 'required|max:50',
            'name' => 'required|max:50',
            'ratings' => 'required|min:1|max:5|size:1',
            'comment' => 'required|max:1000',
        );
        $validator = Validator::make($request->all(), $validation);
        $response['error'] = 0;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        }

        if ($request->ajax() == 1) {
            $response['token'] = csrf_token();
            echo json_encode($response);
            die;
        }
        if ($response['error'] == 0) {
            $input = $request->all();
            $product = Products::getProductById($key);
            if(count($product)>0)
            {
                unset($input['_token']);
                $input['user_id'] = Auth::user()->id;
                $input['product_id'] = $product->id;
                $input['status'] = 2;
                $input['created_at'] = date('Y-m-d H:i:s');
                Reviews::insert($input);
                Session::flash('success', 'Thank you, your reviews has been submitted.');
                return redirect()->back();
            }
            else {
                Session::flash('danger', 'Review cannot be submitted!');
                return redirect()->back();
            }
            
        } else {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        return redirect('/');
    }
    
}
