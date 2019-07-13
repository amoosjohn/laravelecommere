<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Validator,
    Input,
    Redirect;
use App\Content;
use App\Functions\Functions;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class ContentController extends AdminController {

    public function __construct() {
        //parent::__construct();
    }

    public function index() {


        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = 'page';
        }
        $model = Content::orderBy("id","desc")->where("type",'=',$type)->where("deleted","!=",1)->paginate(10);
        return view('admin.content.index', compact('model', 'type'));
        
    }

    public function create() {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = 'page';
        }
        return view('admin.content.create', ['type' => $type]);
    }

    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
                    'title' => 'required|max:255|unique:content',
                    'code' => 'required|max:255|unique:content',
                    'body' => 'required',
                    'image' => 'mimes:jpeg,bmp,png,gif',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $input = $request->all();
        unset($input['_token']);

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/content/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $fileName = Functions::saveImage($file, $destinationPath, $destinationPathThumb);
            $upload = Image::make($destinationPath . $fileName)->fit(280)->save($destinationPathThumb . $fileName);
            $model->image = $fileName;
            $input['image'] = $fileName;
        }
        $input['created_at'] = date("Y-m-d H:i:s");
        Content::insert($input);
        \Session::flash('success', 'Content Added Successfully!');
        return redirect('admin/content/?type=' . $request->type);
    }

    public function edit($id) {
        $model = Content::findOrFail($id);
        $type = $model->type;
        return view('admin.content.edit', compact('model','type'))->with('id', $id);
    }

    public function update($id, Request $request) {
        $id = $request->id;

        $content = Content::findOrFail($id);
        $input = $request->all();

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/content/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $fileName = Functions::saveImage($file, $destinationPath, $destinationPathThumb);
            $upload = Image::make($destinationPath . $fileName)->fit(280)->save($destinationPathThumb . $fileName);
            $input['image'] = $fileName;
        }

        unset($input['_token']);
        $affectedRows = Content::where('id', '=', $id)->update($input);

        \Session::flash('success', 'Updated Successfully!');
        //return redirect('admin/content');
        return redirect('admin/content/?type=' . $content->type);
    }

    public function delete($id) {
        $row = Content::where('id', '=', $id)->update(["deleted"=>1]);
        \Session::flash('success', 'Deleted Successfully!');
        return redirect()->back();
    }
    public function google() {
        $model = Content::where('code','google')->first();
        return view('admin.content.google', compact('model'))->with('id', $model->id);
    }
    public function updateGoogle($id, Request $request) {
        $id = $request->id;

        $content = Content::findOrFail($id);
        $input = $request->all();

        unset($input['_token']);
        $affectedRows = Content::where('id', '=', $id)->update($input);

        \Session::flash('success', 'Updated Successfully!');
        return redirect('admin/content/google');
    }
    
     public function shippingRates() {
        $model = Content::where('code','shipping-rates')->first();
        return view('admin.content.shipping', compact('model'))->with('id', $model->id);
    }
    public function updateShippingRates($id, Request $request) {
        $id = $request->id;

        $content = Content::findOrFail($id);
        $input = $request->all();

        unset($input['_token']);
        $affectedRows = Content::where('id', '=', $id)->update($input);

        \Session::flash('success', 'Updated Successfully!');
        return redirect('admin/content/shipping-rates');
    }

}
