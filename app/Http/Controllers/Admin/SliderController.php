<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Slider;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Functions\Functions;
use App\Categories;

class SliderController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Cafe's For Admin.
     */
    public function index() {

        $model = Slider::with("users")->orderBy("id","desc")->paginate(10);
        $statuses = Slider::$status;
        $colors = Slider::$colors;
        $types = Slider::$types;
        return view('admin.slider.index', compact('model','statuses','colors','types'));
    }

    public function show($id) {
       
    }

    public function create() {
     
        $status = Slider::$status;
        $types = Slider::$types;
        $category = Categories::where("level","=",1)->pluck('name', 'id')->all();
        return view('admin.slider.create', compact('categories', 'key','status','types','category'));
    }

    public function store(Request $request) {
        $rules = array(
                   'title' => 'string|max:255',
                   'type' => 'required|min:1',
                   'status' => 'required|min:1',
                   'url' => 'required|string|max:255',
        );
        $rules['image'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
        $message = [
            'image.max' => 'File size must be less or equal to 2MB.'
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = new Slider;
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/slider/';
            $path = 'uploads/slider/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            /*$extension = $file->getClientOriginalExtension();
            $fileName = rand(111, 999) . time() . '.' . $extension;
            $image = $destinationPath . '/' . $fileName;
            $upload_success = $file->move($destinationPath, $fileName);
            $upload = Image::make($image)->resize(300, 300)->save($destinationPath . $fileName);*/
            $model->image = $path.$fileName;
        }
        $model->user_id = Auth::user()->id;
        $model->type = $request->type;
        $model->title = $request->title;
        $model->url = $request->url;
        $model->status = $request->status;
        $model->category_id = isset($request->category_id)?$request->category_id:0;
        $model->save();
        \Session::flash('success', 'Slider Added Successfully!');
        return redirect('admin/slider');
        }
    }

    public function edit($id) {
        $model = Slider::findOrFail($id);
        $status = Slider::$status;
        $types = Slider::$types;
        $category = Categories::where("level","=",1)->pluck('name', 'id')->all();
        return view('admin.slider.edit', compact('model','status','types','category'))->with('id', $id);
    }

    public function update(Request $request, $id)
    {
        $rules = array(
                   'title' => 'string|max:255', 
                   'type' => 'required|min:1',
                   'status' => 'required|min:1',
                   'url' => 'required|string|max:255',
        );
        $message = [];
        if(isset($request->image)){
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = Slider::find($id);
        $id = $request->slider;

        
        $input = $request->all();
        
        if (Input::hasFile('image')) {
            
            $image = public_path() . '/' . $model->image;
            if (file_exists($image)) {
                unlink($image);
            } 
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/slider/';
            $path = 'uploads/slider/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            
            $input['image'] = $path.$fileName;
        }
        
        unset($input['_method']);
        unset($input['_token']);
        unset($input['key']);
        
        $affectedRows = Slider::where('id', '=', $id)->update($input);
        

        \Session::flash('success', 'Slider Updated Successfully!');
        return redirect('admin/slider');
        }
    }

    public function destroy($id) {
        $row = Slider::find($id);
        $file = public_path() . '/' . $row->image;
        if (file_exists($file)) {
            unlink($file);
        } 
        $row->delete();
        \Session::flash('success', 'Slider Deleted Successfully!');
        return redirect('admin/slider');
    }

    

}
