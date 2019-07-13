<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Categories;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;

class CategoriesController extends AdminController {

    public function __construct() {
        parent::__construct();
    }


    public function index() {
        
        $categories = Categories::leftJoin("categories as subcat","subcat.id","=","categories.parent_id")
                ->leftJoin("categories as parentcat","parentcat.id","=","subcat.parent_id")
                ->leftJoin("urls as u","categories.id","=","u.type_id")
                ->select("categories.*","subcat.name as categoryName","parentcat.name as parentName","u.key")   
                ->orderby("categories.id","desc")
                ->groupBy("categories.id")
                ->paginate(10);
        return view('admin.categories.index', compact('categories','allCategories'));
    }

    public function show($id) {
       
        //$id = $_GET['node'];
        $model = Categories::where('id', '=', $id)->get();
        $data = ['category_info'=>$model];
   ///      d($data['category_info'][0]['name'],1);
         //d($model[0]['name'],1);
        return view('admin.categories.show', ['category_info'=>$model]);
    }

    public function create() {
        //$categories = Categories::where('parent_id',0)->pluck('name', 'id')->all();
        
        return view('admin.categories.create', compact('categories', 'key'));
    }
    public function getCategories() {
        $categories = Categories::where('parent_id',0)->orderby("name","asc")->get();
        $output = array();
        foreach($categories as $category)
        {
            $output[] = $category;
        }
        echo json_encode($output);
        
    }
    public function getSubCategories(Request $request) {
        $parent_id = $request->parent_id;
        $subCategories = Categories::where('parent_id',"=",$parent_id)->orderby("name","asc")->get();
        $output = array();
        foreach($subCategories as $subCategory)
        {
            $output[] = $subCategory;
        }
        echo json_encode($output);
        
    }

    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255|unique:categories',
                   'image' => 'dimensions:min_width=390,min_height=300|mimes:jpg,JPG,jpeg,bmp,png,gif',
                    'commission' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $model = new Categories;

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/categories/images/';
            $destinationPathThumb = public_path() . '/uploads/categories/thumbnail/';
           
            $fileName = Functions::saveImage($file, $destinationPath);
            $image = $destinationPath . '/' . $fileName;
            $upload = Image::make($image)->resize(390,300)->save($destinationPath . $fileName);
            $upload2 = Image::make($image)->resize(200, 200)->save($destinationPathThumb . $fileName);
            $model->image = $fileName;
            $model->thumbnail = $fileName;
            //$destinationPath = public_path() . '/uploads/categories/thumbnail/';
           }
//        if (Input::hasFile('thumbnail')) {
//            $file = Input::file('thumbnail');
//            $destinationPath = public_path() . '/uploads/categories/thumbnail/';
//            $destinationPathThumb = $destinationPath ;
//            $destinationPathBanner = $destinationPath ;
//
//            $extension = $file->getClientOriginalExtension();
//            $fileName = rand(111, 999) . time() . '.' . $extension;
//            $image = $destinationPath . '/' . $fileName;
//            $upload_success = $file->move($destinationPath, $fileName);
//            $upload = Image::make($image)->resize(1600, 300)->save($destinationPathBanner . $fileName);
//            $upload2 = Image::make($image)->resize(350, 200)->save($destinationPathThumb . $fileName);
//            $model->thumbnail = $fileName;
//        }
        $parent_id=0;
        if($request->sub_id!=''){
            $parent_id = $request->sub_id;
        }
        elseif($request->parent_id!=''){        
            $parent_id = $request->parent_id;
        }
        $model->name = $request->name;
        $model->parent_id = $parent_id;
        $model->description = $request->description;
        $model->commission = $request->commission;
        $model->save();
        
        $key = Functions::slugify($request->name);

        $input = array();
        $input['type_id'] = $model->id;
        $input['key'] = $key;//.'-'.$model->id
        $input['type'] = 'category';
        $url = Urls::saveUrl($input);

        \Session::flash('success', 'Category Added Successfully!');
        return redirect('admin/categories');
    }

    public function edit($id) {
        $category = Categories::findOrFail($id);
        $categories = Categories::pluck('name', 'id')->all();
        $categories[0] = 'Root Category';

        $url = Urls::where('type', 'category')->where('type_id', $id)->first();
        if (!empty($url)) {
            $key = $url->key;
        } else {
            $key = null;
        }

        return view('admin.categories.edit', compact('category', 'categories', 'key', 'url'))->with('id', $id);
    }

    public function update($id, Request $request) {

        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
                    'image' => 'dimensions:min_width=390,min_height=300|mimes:jpg,JPG,jpeg,bmp,png,gif',
                    'commission' => 'required',
        ]);

        $urlCheck = Urls::where('type_id', '!=', $id)->where('type', '=', 'category')->where('key', $request->key)->get();

        if (count($urlCheck) > 0) {
            $validator->errors()->add('error_db', 'The key has already been taken.');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $id = $request->id;

        $category = Categories::findOrFail($id);
        $input = $request->all();

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/categories/images/';
            $destinationPathThumb = public_path() . '/uploads/categories/thumbnail/';

            $fileName = Functions::saveImage($file, $destinationPath);
            $image = $destinationPath . '/' . $fileName;
            $upload = Image::make($image)->resize(390,300)->save($destinationPath . $fileName);
            $upload2 = Image::make($image)->resize(200, 200)->save($destinationPathThumb . $fileName);
            $input['image'] = $fileName;
            $input['thumbnail'] = $fileName;
        }
        
        unset($input['_token']);
        unset($input['key']);
        $affectedRows = Categories::where('id', '=', $id)->update($input);
        
        $key = Functions::slugify($input['name']);

        $input = array();
        $input['type_id'] = $id;
        $input['key'] = $key;//.'-'.$id
        $input['type'] = 'category';
        $url = Urls::saveUrl($input);

        \Session::flash('success', 'Category Updated Successfully!');
        return redirect('admin/categories');
    }

    public function delete($id) {
        $row = Categories::find($id);
        if($row->image!='') {
            $file = public_path() . '/uploads/categories/images/' . $row->image;
            $file2 = public_path() . '/uploads/categories/images/' . $row->image;
            if (@file_exists($file)) {
                @unlink($file);
            } 
            if (@file_exists($file2)) {
                @unlink($file2);
            }
        }
        $row->delete();
        $row = Urls::deleteUrl('category',$id);
        \Session::flash('success', 'Category deleted Successfully!');
        return redirect('admin/categories');
    }

    public function create_sub_cat() {
        if (Auth::user()->role->role == 'admin') {
            $categories = Categories::lists('name', 'id');
            return view('admin.categories.create_sub_cat', compact('categories'));
        } else {
            return redirect('home');
        }
    }

    public function store_sub_cat(Request $request) {
        $validator = Validator::make($request->all(), [
                    'parent_id' => 'required',
                    'name' => 'required|max:255',
                    //'url' => 'required',
                    /// 'description' => 'required', |unique:categories
                    'image' => 'mimes:jpeg,bmp,png,gif',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $model = new Categories;

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/categories/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';

            $extension = $file->getClientOriginalExtension();
            $fileName = rand(111, 999) . time() . '.' . $extension;
            $image = $destinationPath . '/' . $fileName;
            $upload_success = $file->move($destinationPath, $fileName);
            $upload = Image::make($image)->resize(150, 150)->save($destinationPathThumb . $fileName);
            $model->image = $fileName;
        }

        $model->parent_id = $request->parent_id;
        $model->name = $request->name;
        $model->teaser = $request->teaser;
        $model->description = $request->description;
        $model->url = $request->url;

        $model->save();
        \Session::flash('success', 'Category Added Successfully!');
        return redirect('admin/categories');
    }
    public function commission() {
        
        $allCategories = Categories::orderby("id","asc")->get();
        $categories = Functions::getCategories($allCategories);
      
        return view('admin.categories.commission', compact('categories','allCategories'));
    }
    public function commissionUpdate(Request $request) {
        if($request->commission!='' && $request->id!=''){
        $input['commission'] =  $request->commission;
        $affectedRows = Categories::where('id', '=', $request->id)->update($input);
        echo '1';
        }
    }
    public function getCategory(Request $request) {
        if($request->ajax()) {
        $parent_id = $request->id;
        $category_id = $request->category_id;
        $subCategories = Categories::where('parent_id',"=",$parent_id)->orderby("name","asc")->get();
        $output = '';
        foreach($subCategories as $subCategory)
        { 
        $seperater ='';    
        $selected =''; 
        if($subCategory->level==2) {
            $seperater = ' <strong>></strong>';
        }    
            $selected = ($category_id==$subCategory->id)?'selected':'';
            $output .= '<option value="'.$subCategory->id.'" '.$selected.'>'. $subCategory->name .''. $seperater .'</option>';

        }
        echo $output;
        }
        
    }

}
