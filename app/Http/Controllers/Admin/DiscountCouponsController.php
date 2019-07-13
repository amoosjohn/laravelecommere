<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect,Config;
use DB;
use Auth;
use App\DiscountCoupons;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;

class DiscountCouponsController extends AdminController
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
        $model = DiscountCoupons::with("users")->orderby("id","desc")->paginate(10);
        $statuses = DiscountCoupons::$status;
        $colors = DiscountCoupons::$colors;
        $types = DiscountCoupons::$types;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.coupons.index', compact('model','statuses','colors','types','symbol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = DiscountCoupons::$status;
        $types = DiscountCoupons::$types;
        
        return view('admin.coupons.create', compact('status','types'));
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
            'code' => 'required|max:20|unique:discount_coupons',
            'type' => 'required|numeric|min:1',
            'status' => 'required|numeric|min:1',
            'amount' => 'required|numeric',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'description' => 'max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $input = $request->all();
        unset($input['_token']);
        $input['user_id'] = Auth::user()->id;
        $input['created_at'] = date('Y-m-d H:i:s');
        DiscountCoupons::insert($input);

        \Session::flash('success', 'Coupon Added Successfully!');
        return redirect('admin/coupons');
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
        $model = DiscountCoupons::findOrFail($id);
        $status = DiscountCoupons::$status;
        $types = DiscountCoupons::$types;
        return view('admin.coupons.edit', compact('model','status','types'))->with('id', $id);
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
        $model = DiscountCoupons::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:20|unique:discount_coupons,code,' . $model->id,
            'type' => 'required|numeric|min:1',
            'status' => 'required|numeric|min:1',
            'amount' => 'required|numeric',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'description' => 'max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        
        $id = $model->id;
        $input = $request->all();
        unset($input['_method']);
        unset($input['_token']);
        $affectedRows = DiscountCoupons::where('id', '=', $id)->update($input);
        \Session::flash('success', 'Coupon Updated Successfully!');
        return redirect('admin/coupons');
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
         DiscountCoupons::destroy($id);

         \Session::flash('success', 'Coupon Deleted Successfully!');
        return redirect('admin/coupons');
    }
}
