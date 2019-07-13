<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
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
use Intervention\Image\Facades\Image as Image;
use App\Functions\Functions;
use App\Products;
use App\Colours;
use App\GalleryImage;
use App\User;
use App\ProductSize;
use App\Size;
use App\ProductVariations;
use App\OrderProducts;

class ProductController extends AdminController
{
    public function __construct() {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Products::count();
        $statuses = Products::$status;
        $colors = Products::$colors;
        $categories = Categories::getCategories();
        $brands = Brands::orderby("name","asc")->pluck('name', 'id')->prepend("Select Brand","")->all();
        $users = User::getVendors();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.products.index', compact('model','symbol','users','statuses','colors','categories','brands'));
    }
    public function search(Request $request)
    {
        $search['product_id'] = $request->input('product_id');
        $search['category_id'] = $request->input('category_id');
        $search['status'] = $request->input('status');
        $search['product_name'] = $request->input('product_name');
        $search['brand_id'] = $request->input('brand_id');
        $search['price_min'] = $request->input('price_min');
        $search['price_max'] = $request->input('price_max');
        $search['created_by']  = $request->input('created_by');
        $search['length']  = $request->input('length');
        $search['popular']  = $request->input('popular');

        $model = Products::search($search);
        $statuses = Products::$status;
        $colors = Products::$colors;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        
        if ($request->ajax()) {
            return view('admin.products.search',compact('model','symbol','statuses','colors'))->render();  
        }
            
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Products::$status;
        $stock_status = Products::$stock_status;
        $categories = Categories::getCategories();
        $brands = Brands::orderby("name","asc")->pluck('name', 'id')->prepend("Select Brand","")->all();
        $session_id = session_id();
        $colours = Colours::where("status","=",1)->orderby("name","asc")->pluck('name', 'id')->prepend("Select Colour","")->all();
      
        return view('admin.products.create', compact('status','categories','brands','stock_status','session_id','colours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255',
                   'category_id' => 'required',
                   //'brand_id' => 'required',
                   'price' => 'required',
//                   'sku' => 'required',
                   'short_description' => 'max:255',
                   'description' => 'required',
                   'status' => 'required|min:1',
                   'meta_title' => 'max:100',
                   'meta_keywords' => 'max:1000',
                   'meta_description' => 'max:255',

        ]);
      
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
       
        $model = new Products;
        $model->name = $request->name;
        $model->user_id = Auth::user()->id;
        $model->category_id = $request->category_id;
        $model->brand_id = $request->brand_id;
        $model->colour_id = $request->colour_id;
        $model->description = $request->description;
        $model->short_description = $request->short_description;
        $model->sku = $request->sku;
        $model->status = $request->status;
        $model->price = $request->price;
        $model->sale_price = $request->sale_price;
        $model->discount = $request->discount;
        $model->quantity = $request->quantity;
        $model->stock_status = $request->stock_status;
        $model->date_available = $request->date_available;
        $model->shipping = $request->shipping;
        $model->weight = $request->weight;
        $model->length = $request->length;
        $model->width = $request->width;
        $model->height = $request->height;    
        $model->meta_title = $request->meta_title;
        $model->meta_keyword = $request->meta_keywords;
        $model->meta_description = $request->meta_description;
        $model->return_policy = $request->return_policy;
        $model->save();
        $product_id = $model->id;
        
        if (count($request->image_id) > 0 && $request->change_id == '') {
                $gallery_temp = $request->session_id;
                
                $gallery_image = GalleryImage::where("product_id", "=", $gallery_temp)->update(['product_id'=>$product_id]);

                $images = $request->image_id;
                $sort_order = $request->sort_order;
                $image_caption = $request->image_caption;
                $i = 0;

                foreach ($images as $image) {
                    $input_image["sort_order"] = $sort_order[$i];
                    $input_image["image_caption"] = $image_caption[$i];

                    $gallery_image = GalleryImage::where("id", "=", $image)->update($input_image);

                    $i++;
                }
            }
        
        /*$key = Functions::slugify($request->name);

        $input = array();
        $input['type_id'] = $model->id;
        $input['key'] = $key.'-'.$model->id;
        $input['type'] = 'product';
        $url = Urls::saveUrl($input);
        */

        \Session::flash('success', 'Product Added Successfully!');
        return redirect('admin/products');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Products::findOrFail($id);
        $status = Products::$status;
        $stock_status = Products::$stock_status;
        $categories = Categories::where("level","=",1)->get();
        $brands = Brands::orderby("name","asc")->pluck('name', 'id')->prepend("Select Brand","")->all();
        $session_id = $id;
        $colours = Colours::where("status","=",1)->orderby("name","asc")->pluck('name', 'id')->prepend("Select Colour","")->all();
        $sizes = Size::orderby("name","asc")->pluck('name', 'id')->prepend("Select Size","")->all();
        $productSizes = ProductSize::where("product_id","=",$id)->get();
        $productVars = ProductVariations::where("product_id","=",$id)->get();
        $products = Products::where("id","!=",$id)->orderby("name","asc")->pluck('name', 'id')->prepend("Select Product","")->all();
        $delivery_from = '';
        $delivery_to = '';
        $parentId = '';
        $categoryId= '';
        if(count($model)>0) {
            if($model->delivery!=''){
                $delivery = explode("-", $model->delivery);
                $delivery_from = (isset($delivery[0]))?$delivery[0]:2;
                $delivery_to = (isset($delivery[1]))?$delivery[1]:5;
            }
            $category = Categories::where("categories.id","=",$model->category_id)
                ->leftJoin("categories as subcat","subcat.id","=","categories.parent_id")
                ->leftJoin("categories as parentcat","parentcat.id","=","subcat.parent_id")
                ->select("subcat.id as categoryId","parentcat.id as parentId")
                ->first();
            $parentId = count($category)>0?$category->parentId:'';
            $categoryId = count($category)>0?$category->categoryId:'';
        } 
        
        return view('admin.products.edit', compact('model','parentId','categoryId','category','delivery_from','delivery_to','products','productVars','sizes','productSizes','stock_status','status','categories','brands','session_id','colours'))->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255',
                   'category_id' => 'required',
                   //'brand_id' => 'required',
                   'price' => 'required',
                   //'sku' => 'required',
                   'short_description' => 'max:255',
                   'description' => 'required',
                   'status' => 'required|min:1',
                   'meta_title' => 'max:100',
                   'meta_keywords' => 'max:1000',
                   'meta_description' => 'max:255',
                   'delivery' => 'required',

        ]);
      
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = Products::find($id);
        $input = $request->all();
        
        unset($input["_method"]);
        unset($input["_token"]);
        unset($input["session_id"]);
        unset($input["change_id"]);
        unset($input["image_id"]);
        unset($input["image_caption"]);
        unset($input["sort_order"]);
        unset($input["size_id"]);
        unset($input["size_quantity"]);
        unset($input["productsize_id"]);
        unset($input["variation_id"]);
        unset($input["productvar_id"]);
        unset($input["delivery_from"]);
        unset($input["delivery_to"]);
        unset($input["commission"]);
        unset($input["childSku"]);
        $input['popular'] = (isset($request->popular))?$request->popular:0;
        $affectedRows = Products::where('id', '=', $id)->update($input);
        if($request->name != $model->name) {
            $key = Functions::slugify($request->name);
            $random = Functions::generateRandomString(6,1);

            $input = array();
            $input['type_id'] = $id;
            $input['key'] = $key.'-'.$random;
            $input['type'] = 'product';
            $url = Urls::saveUrl($input);
        }
        
        if (count($request->image_id) > 0) {
                
                $images = $request->image_id;
                $image_caption = $request->image_caption;
                $i = 0;

                foreach ($images as $image) {
                    $input_image["image_caption"] = $image_caption[$i];
                    $gallery_image = GalleryImage::where("id", "=", $image)->update($input_image);

                    $i++;
                }
            }
        if (count($request->size_id) > 0) {
                $input = array();
                $input['sizes']= $request->size_id;
                $input['quantity']= $request->size_quantity;
                $input['productsize_id']= $request->productsize_id;
                $input['childSku'] = $request->childSku;
                ProductSize::addProductSizes($input,$id);        
        }
        if (count($request->variation_id) > 0) {
            $productvar_id = $request->productvar_id;
            $variations = $request->variation_id;
            $dataVar = array();
            $i = 0;
            foreach ($variations as $variation) {
                $inputVar['productvar_id'] = $productvar_id[$i];
                if ($variation!='') {
                    
                    if ($inputVar['productvar_id'] != 0) {
                        ProductVariations::where('id', '=', $inputVar['productvar_id'])->update(['productvariation_id' =>$variation]);
                    } else {
                       $dataVar[] = array('product_id' => $id, 'productvariation_id' =>$variation,
                             'created_at' => date('Y-m-d H:i:s'));
                    }
                    
                }
               $i++;
            }
            if (count($dataVar) > 0) {

                ProductVariations::insert($dataVar);
            }
        }
        

        \Session::flash('success', 'Product Updated Successfully!');
        return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Products::destroy($id);
        \Session::flash('success', 'Product Deleted Successfully!');
        $check = OrderProducts::checkProducts($id);
        if($check>0) {
            \Session::flash('danger', 'Cannot delete this product because it has ordered by customer');
        }
        else
        {
            $row = Products::destroy($id);
            \Session::flash('success', 'Product Deleted Successfully!');
        }
        return redirect()->back();
    }
    public function sizeDelete($id) {
        $row = ProductSize::find($id)->delete();
        return back()->with('success', 'Product Size deleted successfully.');
    }
    public function commission(Request $request) {
        $id = $request->id;
        $price = $request->price;
        $row = Categories::find($id);
        if(count($row)>0){
            $categoryCommission = $row->commission;
            $per = $categoryCommission / 100;
            $comm = $price * $per;
            echo Functions::moneyFormat($comm);
        }
        else {
            echo 0;
        }
    }
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            GalleryImage::deleteAllImages($toDelete);
            ProductSize::whereIn('product_id',$toDelete)->forceDelete();
            Urls::deleteUrl('product',0,$toDelete);
            Products::whereIn('id',$toDelete)->forceDelete();
        } else {
            Products::whereNotNull('id')->delete();
        }

        \Session::flash('success', 'Selected Product Deleted Successfully!');
        return redirect()->back();
    }
}
