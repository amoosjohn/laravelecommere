<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
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
use App\Content;
use App\Permissions;
use App\Guests;

class OrdersController extends VendorController
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
        $user_id  = Auth::user()->id;
        if(Auth::user()->role_id==4){
            $permission = Permissions::getPermission($user_id,'orders');
            $permission2 = Permissions::getPermission($user_id,'order_detail');
            if($permission==0)
            {
                abort(403);
            }
        }
        $model = Orders::search('',$user_id);
        $statuses = Orders::$status;
        $vendorStatus = User::$status;
        $colors = Orders::$colors;
        $users = User::where("role_id","=",3)
                ->orderby("firstName","asc")->pluck('firstName', 'id')->prepend("Select","")->all();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('vendors.orders.index', compact('model','permission2','vendorStatus','symbol','users','statuses','colors'));
    }
    public function search(Request $request)
    {
        $user_id  = Auth::user()->id;
        if(Auth::user()->role_id==4){
            $permission = Permissions::getPermission($user_id,'orders');
            $permission2 = Permissions::getPermission($user_id,'order_detail');
            if($permission==0)
            {
                abort(403);
            }
        }
        $search = $request->all();
        $model = Orders::search($search,$user_id);
        $statuses = Orders::$status;
        $colors = Orders::$colors;
        $vendorStatus = User::$status;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
       
        
        if ($request->ajax()) {
            return view('vendors.orders.search',compact('model','permission2','vendorStatus','symbol','statuses','colors'))->render();  
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
        $model = Orders::getOrderById($id);
       
        $order = $model['order'];
        if ($order->user_id == 0) {
            $user = Guests::getGuest($order->id);
        } else {
            $user = User::getUser($order->user_id);
        }
        $products = $model['products'];
        $status = Products::$status;
        $colors = Products::$colors;
        $statuses = Orders::$status;
        $vendorStatus = User::$status;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        
        return view('vendors.orders.show', compact('order','vendorStatus','statuses','colors','symbol','status','products','user'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                   'vendorStatus' => 'required|numeric',
                   
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        else{
        $model = Orders::getOrderById($id);
        $products = $model['products'];
        $ids = array();
        $input = $request->all(); 
        unset($input['_method']);
        unset($input['_token']);
        foreach ($products as $product) {
            OrderProducts::where("id","=",$product->id)->update($input);
        }
        \Session::flash('success', 'Order Updated Successfully!');
        return redirect()->back();
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
        $row = Orders::destroy($id);
        \Session::flash('success', 'Order Deleted Successfully!');
        return redirect('vendor/orders');
    }
    public function invoice($id)
    {
        $user_id = Auth::user()->id;
        $model = Orders::getOrderById($id,$user_id);
        if (count($model) > 0) {
            $order = $model['order'];
            $products = $model['products'];
            $statuses = Orders::$status;
            $status = '';
            if (array_key_exists($order->status, $statuses)) {
                $status = $statuses[$order->status];
            }
            $currency = Config::get("params.currencies");
            $symbol = $currency["PKR"]["symbol"];
            $print = 1;
            if ($order->user_id == 0) {
                $user = Guests::getGuest($order->id);
            } else {
                $user = User::getUser($order->user_id);
            }
            return view('emails.welcome', compact('order', 'products', 'symbol', 'status','print','user'));
        }
        else{
            return redirect('vendor/orders');
        }

    }
}
