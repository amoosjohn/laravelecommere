<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use DB;
use Auth;
use App\Size;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;

class SizeController extends AdminController
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
        $model = Size::with("users")->orderby("id","desc")->paginate(10);
        $statuses = Size::$status;
        $colors = Size::$colors;
        return view('admin.size.index', compact('model','statuses','colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Size::$status;
        
        return view('admin.size.create', compact('status'));
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
                   'name' => 'required|max:255|unique:size',
                   'status' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        else{
        $model = new Size; 
        $model->name = $request->name;
        $model->user_id = Auth::user()->id;
        $model->status = $request->status;
        $model->save();
        

        \Session::flash('success', 'Size Added Successfully!');
        return redirect('admin/size');
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
        $model = Size::findOrFail($id);
        $status = Size::$status;
        return view('admin.size.edit', compact('model','status'))->with('id', $id);
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
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        else{
        $model = Size::find($id);
        $id = $request->size;

        $input = $request->all(); 
        unset($input['_method']);
        unset($input['_token']);
        unset($input['key']);
        $affectedRows = Size::where('id', '=', $id)->update($input);
        

        \Session::flash('success', 'Size Updated Successfully!');
        return redirect('admin/size');
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
        $model = Size::find($id);
        $model->delete();

        // redirect
         \Session::flash('success', 'Size Deleted Successfully!');
        return redirect('admin/size');
    }
}
