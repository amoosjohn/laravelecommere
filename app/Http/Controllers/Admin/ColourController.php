<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Colours;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;

class ColourController extends AdminController
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
        $model = Colours::with("users")->orderby("id","desc")->paginate(10);
        $statuses = Colours::$status;
        $colors = Colours::$colors;
        return view('admin.colours.index', compact('model','statuses','colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Colours::$status;
        
        return view('admin.colours.create', compact('status'));
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
                   'name' => 'required|max:255|unique:colours',
                   'status' => 'required|min:1',
                   'image' => 'mimes:jpeg,bmp,png,gif,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = new Colours;

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/colours/images/';
            $path = 'uploads/brands/colours/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            $model->image = $path.$fileName;
        }
        
        $model->name = $request->name;
        $model->user_id = Auth::user()->id;
        $model->status = $request->status;
        $model->save();
        

        \Session::flash('success', 'Colour Added Successfully!');
        return redirect('admin/colours');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Colours::findOrFail($id);
        $status = Colours::$status;
        return view('admin.colours.edit', compact('model','status'))->with('id', $id);
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
                   'status' => 'required|min:1',
                   
        ]);
        if (Input::hasFile('image')) {
            $validator['image'] = 'mimes:jpeg,bmp,png,gif,jpg';
        }
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = Colours::find($id);
        $id = $request->colour;

        
        $input = $request->all();
        
        if (Input::hasFile('image')) {
            
            $image = public_path() . '/' . $model->image;
            if (file_exists($image)) {
                unlink($image);
            } 
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/colours/images/';
            $path = 'uploads/colours/colours/' ;
            
            $fileName = Functions::saveImage($file, $destinationPath,'');
            
            $input['image'] = $fileName;
        }
        
        unset($input['_method']);
        unset($input['_token']);
        unset($input['key']);
        
        $affectedRows = Colours::where('id', '=', $id)->update($input);
        

        \Session::flash('success', 'Colour Updated Successfully!');
        return redirect('admin/colours');
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
        $model = Colours::find($id);
        $model->delete();

        // redirect
         \Session::flash('success', 'Colour Deleted Successfully!');
        return redirect('admin/colours');
    }
}
