<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Brands;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Functions\Functions;

class BrandsController extends VendorController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Cafe's For Admin.
     */
    public function index() {

        $user_id = Auth::user()->id;
        $model = Brands::with("users")->where("user_id","=",$user_id)->paginate(10);
        $statuses = Brands::$status;
        $colors = Brands::$colors;
        return view('vendors.brands.index', compact('model','statuses','colors'));
    }

    public function show($id) {
        $model = Brands::where('id', '=', $id)->get();
        $data = ['category_info'=>$model];

        return view('vendors.brands.show', ['category_info'=>$model]);
    }

    public function create() {
     
        $key = null;
        $status = Brands::$status;
        
        return view('vendors.brands.create', compact('categories', 'key','status'));
    }

    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255|unique:brands',
                   'status' => 'required|min:1',
                   'image' => 'required|mimes:jpeg,bmp,png,gif,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = new Brands;

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/brands/images/';
            $path = 'uploads/brands/images/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            /*$extension = $file->getClientOriginalExtension();
            $fileName = rand(111, 999) . time() . '.' . $extension;
            $image = $destinationPath . '/' . $fileName;
            $upload_success = $file->move($destinationPath, $fileName);
            $upload = Image::make($image)->resize(300, 300)->save($destinationPath . $fileName);*/
            $model->image = $path.$fileName;
        }
        
        $model->name = $request->name;
        $model->user_id = Auth::user()->id;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();
        
        $key = Functions::slugify($request->name);

        $input = array();
        $input['type_id'] = $model->id;
        $input['key'] = $key.'-'.$model->id;
        $input['type'] = 'brand';
        $url = Urls::saveUrl($input);


        \Session::flash('success', 'Brand Added Successfully!');
        return redirect('vendor/brands');
        }
    }

    public function edit($id) {
        $model = Brands::findOrFail($id);
        $status = Brands::$status;
        return view('vendors.brands.edit', compact('model','status'))->with('id', $id);
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
            $input['image'] = $path.$fileName;
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
        return redirect('vendor/brands');
    }

    public function delete($id) {
        $row = Brands::find($id);
        $file = public_path() . '/' . $row->image;
        if (file_exists($file)) {
            unlink($file);
        } 
        $row->delete();
        \Session::flash('success', 'Brand Deleted Successfully!');
        return redirect('vendor/brands');
    }

    

}
