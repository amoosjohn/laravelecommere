<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Input,
    Redirect;
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

class ProductsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Cafe's For Admin.
     */
    public function index() {

        $model = Products::with("users")->orderby("id","desc")->paginate(10);
        $statuses = Products::$status;
        $colors = Products::$colors;
        return view('admin.products.index', compact('model','statuses','colors'));
    }

    public function show($id) {
        $model = Products::where('id', '=', $id)->get();

        return view('admin.products.show', ['category_info'=>$model]);
    }

    public function create() {
     
        $status = Products::$status;
        
        return view('admin.products.create', compact('status'));
    }

    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255',
                   'price' => 'required',
                   'status' => 'required|min:1',
                   'description' => 'required|min:1',
                   
        ]);
        //'image' => 'mimes:jpeg,bmp,png,gif,jpg',
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        else{
        /*if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/brands/images/';
            $path = 'uploads/brands/images/' ;
            
            $model->image = $path.$fileName;
        }*/
        $model = new Products;
        $model->name = $request->name;
        $model->user_id = Auth::user()->id;
        $model->description = $request->description;
        $model->short_description = $request->short_description;
        $model->sku = $request->sku;
        $model->status = $request->status;
        $model->price = $request->price;
        $model->description = $request->description;
        $model->meta_title = $request->meta_title;
        $model->meta_keyword = $request->meta_keywords;
        $model->meta_description = $request->meta_description;
        $model->save();
        
        $key = Functions::slugify($request->name);

        $input = array();
        $input['type_id'] = $model->id;
        $input['key'] = $key.'-'.$model->id;
        $input['type'] = 'product';
        $url = Urls::saveUrl($input);


        \Session::flash('success', 'Product Added Successfully!');
        return redirect('admin/products');
        }
    }

    public function edit($id) {
        $model = Brands::findOrFail($id);
        $status = Brands::$status;
        return view('admin.brands.edit', compact('model','status'))->with('id', $id);
    }

    public function update($id, Request $request) {

      $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255|unique:brands,name,'.$id,
                   'status' => 'required|min:1',
                   'image' => 'mimes:jpeg,bmp,png,gif,jpg',
        ]);
        $url = Urls::where('type', 'brand')->where('type_id', $id)->first();
        if (!empty($url)) {
            $key = $url->key;
        } else {
            $key = null;
        }
        $urlCheck = Urls::where('type_id', '!=', $id)
                    ->where('type', '=', 'brand')
                    ->where('key',$key)->get();
        if (count($urlCheck) > 0) {
            $validator->errors()->add('error_db', 'The key has already been taken.');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $id = $request->id;

        $model = Brands::findOrFail($id);
        $input = $request->all();

        if (Input::hasFile('image')) {
            $image = public_path() . '/' . $model->image;
            if (file_exists($image)) {
                unlink($image);
            } 
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/brands/images/';
            $path = 'uploads/brands/images/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input['image'] = $fileName;
        }
        
       
        unset($input['_token']);
        unset($input['key']);
        $affectedRows = Brands::where('id', '=', $id)->update($input);
        
        $key = Functions::slugify($input['name']);

        $input = array();
        $input['type_id'] = $id;
        $input['key'] = $key.'-'.$id;
        $input['type'] = 'brand';
        $url = Urls::saveUrl($input);

        \Session::flash('success', 'Updated Successfully!');
        return redirect('admin/products');
    }

    public function delete($id) {
        $row = Products::find($id);
        $file = public_path() . '/' . $row->image;
        if (file_exists($file)) {
            unlink($file);
        } 
        $row->delete();
        \Session::flash('success', 'Brand Deleted Successfully!');
        return redirect('admin/products');
    }

    

}
