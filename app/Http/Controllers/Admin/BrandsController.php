<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Categories;
use App\Brands;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Functions\Functions;
use App\User;

class BrandsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Cafe's For Admin.
     */
    public function index() {

        $model = Brands::search('');
        $statuses = Brands::$status;
        $colors = Brands::$colors;
        $users = User::whereIn("role_id",array(1,2))->where("status","=",1)
                ->orderby("firstName","asc")->pluck('firstName', 'id')->prepend("Select","")->all();
        return view('admin.brands.index', compact('model','statuses','colors','users'));
    }
    public function search(Request $request)
    {
        $data['search'] = $request->all();
        $model = Brands::search($data['search']);
        $statuses = Brands::$status;
        $colors = Brands::$colors;
        return view('admin.brands.ajax.list',compact('model','statuses','colors'));
            
    }

    public function show($id) {
        $model = Brands::where('id', '=', $id)->get();
        $data = ['category_info'=>$model];

        return view('admin.brands.show', ['category_info'=>$model]);
    }

    public function create() {
     
        $key = null;
        $status = Brands::$status;
        
        return view('admin.brands.create', compact('categories', 'key','status'));
    }

    public function insert(Request $request) {
        
        $message = [
            'image.max' => 'Image size must be less or equal to 2MB.',
            'image.dimensions' => 'Image must be upload with minimum 100x100 demension'
        ];
        $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255|unique:brands',
                   'status' => 'required|min:1',
                   'image' => 'required|dimensions:min_width=100,min_height=100|mimes:jpeg,bmp,png,gif,jpg|max:2000',
        ],$message);
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
        $model->top = isset($request->top)?$request->top:0;
        $model->fashion = isset($request->fashion)?$request->fashion:0;
        $model->electronic = isset($request->electronic)?$request->electronic:0;
        $model->save();
        
        $key = Functions::slugify($request->name);

        $input = array();
        $input['type_id'] = $model->id;
        $input['key'] = $key.'-'.$model->id;
        $input['type'] = 'brand';
        $url = Urls::saveUrl($input);


        \Session::flash('success', 'Brand Added Successfully!');
        return redirect('admin/brands');
        }
    }

    public function edit($id) {
        $model = Brands::findOrFail($id);
        $status = Brands::$status;
        return view('admin.brands.edit', compact('model','status'))->with('id', $id);
    }

    public function update($id, Request $request) {

     $message = [
            'image.max' => 'Image size must be less or equal to 2MB.',
            'image.dimensions' => 'Image must be upload with minimum 100x100 demension'
        ];   
      $validator = Validator::make($request->all(), [
                   'name' => 'required|max:255|unique:brands,name,'.$id,
                   'status' => 'required|min:1',
                   'image' => 'dimensions:min_width=100,min_height=100|mimes:jpeg,bmp,png,gif,jpg|mimes:jpeg,bmp,png,gif,jpg',
        ],$message);
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
            if($model->image!='') {
                $image = public_path() . '/' . $model->image;
                if (file_exists($image)) {
                    unlink($image);
                } 
            }
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/brands/images/';
            $path = 'uploads/brands/images/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input['image'] = $path.$fileName;
        }
        unset($input['_token']);
        unset($input['key']);
        $input['top'] = isset($request->top)?$request->top:0;
        $input['fashion'] = isset($request->fashion)?$request->fashion:0;
        $input['electronic'] = isset($request->electronic)?$request->electronic:0;
        $affectedRows = Brands::where('id', '=', $id)->update($input);
        
        $key = Functions::slugify($input['name']);

        $input = array();
        $input['type_id'] = $id;
        $input['key'] = $key.'-'.$id;
        $input['type'] = 'brand';
        $url = Urls::saveUrl($input);

        \Session::flash('success', 'Updated Successfully!');
        return redirect('admin/brands');
    }

    public function delete($id) {
        $row = Brands::find($id);
        if($row->image!='') {
            $file = public_path() . '/' . $row->image;
            if (@file_exists($file)) {
                @unlink($file);
            } 
        }
        $row->delete();
        Urls::deleteUrl('brand',$id);
        \Session::flash('success', 'Brand Deleted Successfully!');
        return redirect('admin/brands');
    }

    

}
