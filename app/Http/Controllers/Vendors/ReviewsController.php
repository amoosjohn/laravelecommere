<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
use Validator,
    Input,
    Redirect,Config;
use DB;
use Auth;
use App\User;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use App\Functions\Functions;
use App\Products;
use App\Reviews;

class ReviewsController extends VendorController
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
        $user_id = Auth::user()->id;
        $model = Reviews::search('',$user_id);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('vendors.reviews.index', compact('model','statuses','colors'));
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
        
        $user_id = Auth::user()->id;
        $model = Reviews::search('',$user_id);
        $statuses = User::$status;
        $colors = User::$colors;
        
        if ($request->ajax()) {
            return view('vendors.reviews.search',compact('model','symbol','statuses','colors'))->render();  
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
        $model = Reviews::with("users")->with("products")->find($id);
        $status = User::$status;
        return view('vendors.reviews.edit', compact('model','status'))->with('id', $id);
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
                   'status' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = Reviews::find($id);
        $input = $request->all();
        unset($input["_method"]);
        unset($input["_token"]);
        $model = Reviews::where("id","=",$id)->update($input);

        \Session::flash('success', 'Status Updated Successfully!');
        return redirect('vendor/reviews');
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
        $row = Products::find($id)->delete();
        \Session::flash('success', 'Product Deleted Successfully!');
        return redirect('vendor/reviews');
    }
}
?>