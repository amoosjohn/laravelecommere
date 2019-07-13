<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Requests;
use App\Http\Controllers\VendorController;
use Validator,
    Input,
    Redirect,Config;
use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use App\Orders;
use App\User;
use App\OrderProducts;
use App\Products;
use App\Payments;


class ReportController extends VendorController
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
        $search['user_id'] = $user_id;
        $model = Orders::report($search);    
        $users = User::getVendors();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('vendors.report.index', compact('model','symbol','users','statuses'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
        $search = $request->all();
        $model = Orders::report($search);
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('vendors.report.search',compact('model','vendorStatus','symbol','statuses','colors'))->render();  
        }      
    }
    public function show()
    {
        $user_id = Auth::user()->id;
        $model = Payments::with("users")->where('user_id', '=', $user_id)->orderby("id","desc")->get();
        $methods = Payments::$methods;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('vendors.report.show',compact('model','methods','symbol'));
    }
    
    
}
