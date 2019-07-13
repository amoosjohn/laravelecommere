<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Sections;
use App\Categories;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Functions\Functions;

class SectionsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

   
    public function index() {

        $model = Sections::with("users")->with("categories")->orderBy("id","desc")->paginate(10);
        $statuses = Sections::$status;
        $colors = Sections::$colors;
        $types = Sections::$types;
        
        return view('admin.sections.index', compact('model','categories','statuses','colors','types'));
    }

    public function show($id,Request $request) {
       
        if($request->ajax()) {
          if(isset($request->category2)){
              $category2 = explode(",",$request->category2);
          }
          if(isset($request->category3)){
              $category3 = explode(",",$request->category3);
          }
          $model = Categories::with("children")
                  ->where("parent_id", "=", $id)
                  ->get();
          $checked = '';
          return view('admin.sections.categories', compact('model','category2','category3','checked'));
        }
    }

    public function create() {
     
        $status = Sections::$status;
        $types = Sections::$types;
        $categories = Categories::orderby("id","asc")->where("level","=",1)
                ->pluck('name', 'id')->prepend("Select Category","")->all();
        return view('admin.sections.create', compact('categories', 'key','status','types'));
    }

    public function store(Request $request) {
        $rules = array(
                   'type' => 'required|min:1',
                   'status' => 'required|min:1',
                   'category' => 'required|unique:sections',
        );
        $rules['image'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
        $message = [
            'image.max' => 'File size must be less or equal to 2MB.'
        ];
        if (Input::hasFile('image2')) {
            $rules['image2'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image2.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        if (Input::hasFile('image3')) {
            $rules['image3'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image3.max' => 'File size must be less or equal to 2MB.'
            ];
            
        }
        if (Input::hasFile('image4')) {
            $rules['image4'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image4.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        if (Input::hasFile('image5')) {
            $rules['image5'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image5.max' => 'File size must be less or equal to 2MB.'
            ];
            
        }
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $input = $request->all();
        unset($input["_token"]);
        unset($input["image"]);
        unset($input["image2"]);
        unset($input["image3"]);
        unset($input["image4"]);
        unset($input["image5"]);
        unset($input["category2"]);
        unset($input["category3"]);
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/sections/images/';
            $path = 'uploads/sections/images/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image"] = $path.$fileName;
        }
        if (Input::hasFile('image2')) {
            $file = Input::file('image2');
            $destinationPath = public_path() . '/uploads/sections/images2/';
            $path = 'uploads/sections/images2/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image2"] = $path.$fileName;
        }
        if (Input::hasFile('image3')) {
            $file = Input::file('image3');
            $destinationPath = public_path() . '/uploads/sections/images3/';
            $path = 'uploads/sections/images3/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image3"] = $path.$fileName;
        }
        if (Input::hasFile('image4')) {
            $file = Input::file('image4');
            $destinationPath = public_path() . '/uploads/sections/images4/';
            $path = 'uploads/sections/images4/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image4"] = $path.$fileName;
        }
        if (Input::hasFile('image5')) {
            $file = Input::file('image5');
            $destinationPath = public_path() . '/uploads/sections/images5/';
            $path = 'uploads/sections/images5/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image5"] = $path.$fileName;
        }
        if(count($request->category2)>0) {
            $input["category2"] = implode(",", $request->category2);
        }
        if(count($request->category3)>0) {
            $input["category3"] = implode(",", $request->category3);
        }
        $input["created_at"] = date('Y-m-d H:i:s');
        $input["user_id"] = Auth::user()->id;
        Sections::insert($input);
       
        \Session::flash('success', 'Section Added Successfully!');
        return redirect('admin/sections');
        }
    }

    public function edit($id) {
        $model = Sections::findOrFail($id);
        $status = Sections::$status;
        $types = Sections::$types;
        $categories = Categories::orderby("id","asc")->where("level","=",1)
                ->pluck('name', 'id')->prepend("Select Category","")->all();
        return view('admin.sections.edit', compact('model','status','types','categories'))->with('id', $id);
    }

    public function update(Request $request, $id)
    {
        $model = Sections::find($id);
        $rules = array(
                   'type' => 'required|min:1',
                   'status' => 'required|min:1',
                   'category' => 'required|unique:sections,category,'.$model->id,
        );
        
        $message = [];
        if(isset($request->image)){
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        if (Input::hasFile('image2')) {
            $rules['image2'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image2.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        if (Input::hasFile('image3')) {
            $rules['image3'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image3.max' => 'File size must be less or equal to 2MB.'
            ];
            
        }
        if (Input::hasFile('image4')) {
            $rules['image4'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image4.max' => 'File size must be less or equal to 2MB.'
            ];
        }
        if (Input::hasFile('image5')) {
            $rules['image5'] = 'required|mimes:jpeg,bmp,png,gif,jpg,JPG,JPEG|max:2000';
            $message = [
                'image5.max' => 'File size must be less or equal to 2MB.'
            ];
            
        }
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        //$id = $request->sections;
        $input = $request->all();
        unset($input['_method']);
        unset($input['_token']);
        unset($input["image"]);
        unset($input["image2"]);
        unset($input["image3"]);
        unset($input["image4"]);
        unset($input["image5"]);
        unset($input["category2"]);
        unset($input["category3"]);
        
        if (Input::hasFile('image')) {
            
            $image = public_path() . '/' . $model->image;
            if (file_exists($image)) {
                unlink($image);
            }
            $file = Input::file('image');
            //dd($file);
            $destinationPath = public_path() . '/uploads/sections/images/';
            $path = 'uploads/sections/images/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image"] = $path.$fileName;
        }
        if (Input::hasFile('image2')) {
            $image2 = public_path() . '/' . $model->image2;
            if (file_exists($image2)) {
                unlink($image2);
            }
            $file = Input::file('image2');
            $destinationPath = public_path() . '/uploads/sections/images2/';
            $path = 'uploads/sections/images2/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image2"] = $path.$fileName;
        }
        if (Input::hasFile('image3')) {
            $image3 = public_path() . '/' . $model->image3;
            if (file_exists($image3)) {
                unlink($image3);
            }
            $file = Input::file('image3');
            $destinationPath = public_path() . '/uploads/sections/images3/';
            $path = 'uploads/sections/images3/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image3"] = $path.$fileName;
        }
        if (Input::hasFile('image4')) {
            $image4 = public_path() . '/' . $model->image4;
            if (file_exists($image4)) {
                unlink($image4);
            }
            $file = Input::file('image4');
            $destinationPath = public_path() . '/uploads/sections/images4/';
            $path = 'uploads/sections/images4/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image4"] = $path.$fileName;
        }
        if (Input::hasFile('image5')) {
            $image5 = public_path() . '/' . $model->image5;
            if (file_exists($image5)) {
                unlink($image5);
            }
            $file = Input::file('image5');
            $destinationPath = public_path() . '/uploads/sections/images5/';
            $path = 'uploads/sections/images5/' ;
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $input["image5"] = $path.$fileName;
        }
        if(count($request->category2)>0) {
            $input["category2"] = implode(",", $request->category2);
        }
        if(count($request->category3)>0) {
            $input["category3"] = implode(",", $request->category3);
        }
        
        $affectedRows = Sections::where('id', '=', $id)->update($input);
        

        \Session::flash('success', 'Section Updated Successfully!');
        return redirect('admin/sections');
        }
    }

    public function destroy($id) {
        $row = Sections::destroy($id);
        /*$file = public_path() . '/' . $row->image;
        if (file_exists($file)) {
            unlink($file);
        } 
        $row->delete();*/
        \Session::flash('success', 'Section Deleted Successfully!');
        return redirect('admin/sections');
    }

    

}
