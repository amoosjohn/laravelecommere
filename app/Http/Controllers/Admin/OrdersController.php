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
use App\Content;
use App\OrdersDiscounts;
use App\Guests;

class OrdersController extends AdminController
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
        $model = Orders::count();
        $statuses = Orders::$status;
        $colors = Orders::$colors;
        $vendorStatus = User::$status;
        $users = User::where("role_id","=",3)
                ->orderby("firstName","asc")->pluck('firstName', 'id')->prepend("Select","")->all();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.orders.index', compact('model','vendorStatus','symbol','users','statuses','colors'));
    }
    public function search(Request $request)
    {
        $search = $request->all();
        $model = Orders::search($search);
        $statuses = Orders::$status;
        $colors = Orders::$colors;
        $vendorStatus = User::$status;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        
        if ($request->ajax()) {
            return view('admin.orders.search',compact('model','vendorStatus','symbol','statuses','colors'))->render();  
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
        
        return view('admin.orders.show', compact('order','vendorStatus','statuses','colors','symbol','status','products','user'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                   'status' => 'required|numeric',
                   
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        else{
        $model = Orders::find($id);
        $input = $request->all(); 
        unset($input['_method']);
        unset($input['_token']);
        if($request->status!=$model->status){
            $sendEmail = $this->sendEmail($id);
        }
        $affectedRows = Orders::where('id', '=', $id)->update($input);
        
        \Session::flash('success', 'Order Updated Successfully!');
        return redirect()->back();
        }
    }
    public function send($id)
    {
        $sendEmail = $this->sendEmail($id);
        if($sendEmail==1) {
            \Session::flash('success', 'Email confirmation has been sent!');
            return redirect()->back();
        }
        else {
            \Session::flash('success', 'Email cannot send!');
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
        return redirect('admin/orders');
    }
    public function invoice($id)
    {
        $model = Orders::getOrderById($id);
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
            return redirect('admin/orders');
        }

    }
    function sendEmail($id) {
        $model = Orders::getOrderById($id);
        if (count($model) > 0) {
            $order = $model['order'];
            $products = $model['products'];
            $email = $order->email; 
            $statuses = Orders::$status;
            $status = '';
            if (array_key_exists($order->status, $statuses)) {
                $status = $statuses[$order->status];
            }
            $currency = Config::get("params.currencies");
            $symbol = $currency["PKR"]["symbol"];
            $subject = 'Customer Order Invoice';
            if ($order->user_id == 0) {
                $user = Guests::getGuest($order->id);
            } else {
                $user = User::getUser($order->user_id);
            }
            $body = view('emails.welcome', compact('order', 'products', 'symbol', 'status','user'));
            $send_email = Functions::sendEmail($email, $subject, $body, '');
            $admin_email = Config::get("params.admin_email");
            Functions::sendEmail($admin_email, $subject, $body, '');
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
