<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
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


class ReportController extends AdminController
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
//        $model = Orders::join("order_products as op","op.id","=",
//                 DB::raw("(select id from order_products where order_products.order_id = orders.id order by created_at desc limit 1)"))
//                ->join("products as pro","pro.id","=",                 
//                 DB::raw("(select id from products where products.id = op.product_id order by created_at desc limit 1)"))
//
//                ->join("users as u","pro.user_id","=","u.id")
//                //->leftJoin("payments as pay","u.id","=","pay.user_id")
//                ->select("u.firstName")
//                //->selectRaw("SUM(pay.amount) as payAmount")
//                ->selectRaw("SUM(orders.grandTotal) as orderAmount")
//                //->selectRaw("SUM(op.totalCommission) as totalCommission")
//                ->where('orders.status','=',5)
//                ->groupBy('u.id')
//                ->get();
        $model = Orders::report();    
        $users = User::getVendors();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.report.index', compact('model','symbol','users','statuses'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
        $search = $request->all();
        $model = Orders::report($search);
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.report.search',compact('model','vendorStatus','symbol','statuses','colors'))->render();  
        }      
    }
    public function show($id)
    {
        $model = Payments::with("users")->where('user_id', '=', $id)->orderby("id","desc")->get();
        $methods = Payments::$methods;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.report.show',compact('model','methods','symbol'));
    }
    
    
}
