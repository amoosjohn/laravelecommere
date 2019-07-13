<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
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
use App\Size;
use App\ProductSize;
use App\ProductVariations;
use App\UsersPermissions;
use App\Permissions;
use App\OrderProducts;

class ProductController extends VendorController
{
    private $sessionId;
    public function __construct() {
        session_start();
        $this->sessionId = session_id();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
            $permission = Permissions::getPermission($user_id,'product_list');
            $permission2 = Permissions::getPermission($user_id,'product_create');
            $permission3 = Permissions::getPermission($user_id,'product_import');
            $permission4 = Permissions::getPermission($user_id,'product_export');
            $permissionEdit = Permissions::getPermission($user_id,'product_update');
            $permissionDel = Permissions::getPermission($user_id,'product_delete');
            if($permission==0)
            {
                abort(403);
            }
        }
        $vendor_id = Auth::user()->vendor_id;
        if($vendor_id!=0) {
            $user_id = $vendor_id;
        }
        $model = Products::where('user_id','=',$user_id)->count();
        //$this->authorize('product_list',$model);
        $statuses = Products::$status;
        $colors = Products::$colors;
        $categories = Categories::getCategories();
        $brands = Brands::orderby("name","asc")->pluck('name', 'id')->prepend("Select Brand","")->all();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        session_regenerate_id();
        return view('vendors.products.index', compact('model','permissionEdit','permissionDel','permission2','permission3','permission4','symbol','statuses','colors','categories','brands'));
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
        $search['length']  = $request->input('length');
        
        $user_id = Auth::user()->id;
        $model = Products::search($search,$user_id);
        $statuses = Products::$status;
        $colors = Products::$colors;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $permissionEdit = Permissions::getPermission($user_id,'product_update');
        $permissionDel = Permissions::getPermission($user_id,'product_delete');
        
        if ($request->ajax()) {
            return view('vendors.products.search',compact('model','permissionEdit','permissionDel','symbol','statuses','colors'))->render();  
        }
            
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
        $permission = Permissions::getPermission($user_id,'product_create');
        if($permission==0)
        {
            abort(403);
        }
        }
        $status = Products::$status;
        $stock_status = Products::$stock_status;
        $categories = Categories::where("level","=",1)->get();
        $brands = Brands::where("status","=",1)->orderby("name","asc")->pluck('name', 'id')->prepend("Select Brand","")->all();
        $session_id = $this->sessionId;
        $colours = Colours::where("status","=",1)->orderby("name","asc")->pluck('name', 'id')->prepend("Select Colour","")->all();
        $sizes = Size::orderby("name","asc")->pluck('name', 'id')->prepend("Select Size","")->all();
        $products = Products::orderby("name","asc")->pluck('name', 'id')->prepend("Select Product","")->all();
      
        return view('vendors.products.create', compact('status','products','sizes','categories','brands','stock_status','session_id','colours'));
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
        //'brand_id' => 'required',
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
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
        unset($input["productsize_id"]);
        unset($input["variation_id"]);
        unset($input["productvar_id"]);
        unset($input["delivery_from"]);
        unset($input["delivery_to"]);
        unset($input["commission"]);
        unset($input["childSku"]);
        $input['user_id'] = Auth::user()->id;
        $input['return_policy'] = '';
        $input['created_at'] = date('Y-m-d H:i:s');
        $product_id = Products::insertGetId($input);
        
        if (count($request->image_id) > 0) {
            $gallery_temp = $request->session_id;
            $gallery_image = GalleryImage::where("product_id", "=", $gallery_temp)->update(['product_id'=>$product_id]);
            $images = $request->image_id;
            $image_caption = $request->image_caption;
            $i = 0;
            foreach ($images as $image) {
                $input_image["image_caption"] = $image_caption[$i];
                $gallery_image = GalleryImage::where("id", "=", $image)->update($input_image);
                $i++;
            }
            GalleryImage::where("product_id", "=", $gallery_temp)->delete();
        }
        if (count($request->size_id) > 0) {
                $input = array();
                $input['sizes']= $request->size_id;
                $input['quantity']= $request->size_quantity;
                $input['productsize_id']= 0;
                $input['childSku'] = $request->childSku;
                ProductSize::addProductSizes($input,$product_id);     
        }
        if (count($request->variation_id) > 0) {
            $variations = $request->variation_id;
            $dataVar = array();
            foreach ($variations as $variation) {

                if ($variation!='') {
                    $dataVar[] = array('product_id' => $product_id, 'productvariation_id' =>$variation,
                             'created_at' => date('Y-m-d H:i:s'));
                }
            }
            if (count($dataVar) > 0) {

                ProductVariations::insert($dataVar);
            }
        }
        
        
        $key = Functions::slugify($request->name);
        $random = Functions::generateRandomString(6,1);

        $input = array();
        $input['type_id'] = $product_id;
        $input['key'] = $key.'-'.$random;
        $input['type'] = 'product';
        $url = Urls::saveUrl($input);
        session_regenerate_id();
        
        
        \Session::flash('success', 'Product Added Successfully!');
        return redirect('vendor/products/create');
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
        $user_id = Auth::user()->id;
        $model = Products::findOrFail($id);
        if(Auth::user()->role_id==4){
        $permission = Permissions::getPermission($user_id,'product_update');
        if($permission==0)
        {
            abort(403);
        }
        }
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
            $model->weight = ($model->weight!='')?$model->weight:0;
        }
       
        return view('vendors.products.edit', compact('model','category','delivery_from','delivery_to','products','productVars','stock_status','productSizes','sizes','status','categories','brands','session_id','colours'))->with('id', $id);
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
        //'brand_id' => 'required',
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
        unset($input["productsize_id"]);
        unset($input["variation_id"]);
        unset($input["productvar_id"]);
        unset($input["delivery_from"]);
        unset($input["delivery_to"]);
        unset($input["commission"]);
        unset($input["childSku"]);
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
        
        session_regenerate_id();

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
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
        $permission = Permissions::getPermission($user_id,'product_delete');
            if($permission==0)
            {
                abort(403);
            }
        }
        $check = OrderProducts::checkProducts($id);
        if($check>0) {
            \Session::flash('danger', 'Cannot delete this product because it has ordered by customers');
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
        }

        \Session::flash('success', 'Selected Product Deleted Successfully!');
        return redirect()->back();
    }
    
}
?>