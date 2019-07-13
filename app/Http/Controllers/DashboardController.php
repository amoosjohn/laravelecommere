<?php

namespace App\Http\Controllers;

use Validator,
    Input,
    Redirect,Config,Session,Hash;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Functions\Functions;
use App\User;
use App\Address;
use App\Orders;
use App\Cities;
use App\Products;
use App\Reviews;

class DashboardController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function index() {
        $user_id = Auth::user()->id;
        $billing = Address::getAddress($user_id,1);
        
        $completed = Orders::where('user_id','=',$user_id)
                   ->where('status','=',5)->count();
        $pending = Orders::where('user_id','=',$user_id)
                   ->where('status','=',1)->count();
        return view('front.customers.index',compact('billing','completed','pending'));
    }
    public function account() {
        $user_id = Auth::user()->id;
        $model = User::find($user_id);
        $date = null;
        $month = null;
        $year = null;
        if($model->dob!='') {
            $dob = explode('-',$model->dob);
            $date = $dob[0];
            $month = $dob[1];
            $year = $dob[2];
        }
        $regions = Cities::regions();
        $address = Address::getAddress($user_id,1);
        return view('front.customers.accounts',compact('model','regions','address','date','month','year'));
    }
    public function update(Request $request) {
        $user_id = Auth::user()->id;
        $model = User::find($user_id);
        $validation = array(
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'gender' => 'required|max:10',
            'email' => 'required|email|max:50|unique:users,email,' . $model->id,
            'address' => 'required|max:100',
            'mobile' => 'required|max:20',
            'region' => 'required|numeric',
            'city' => 'required|numeric',
        );
        $validator = Validator::make($request->all(), $validation);
        $response['error'] = 0;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        }

        if ($response['error'] == 0) {
            $input = $request->all();
            unset($input['_token']);;
            unset($input['deliveryAddress']);
            unset($input['date']);
            unset($input['month']);
            unset($input['year']);
            unset($input['phone']);
            $input['newsletter'] = (isset($request->newsletter))?$request->newsletter:0;
            $input['dob'] = $request->date.'-'.$request->month.'-'.$request->year;
            User::where("id","=",$user_id)->update($input);
            /*
            $billing = Address::getAddress($user_id,1);
            if(count($billing)>0){
                $input = array();
                $input['address'] = $request->address;
                $input['phone'] = $request->phone;
                $input['region'] = $request->region;
                $input['city'] = $request->city;
                $update = Address::where('user_id','=',$user_id)
                          ->where('type','=',1)->update($input);
            }
            else {
                $input = array();
                $input['firstName'] = $request->firstName;
                $input['lastName'] = $request->lastName;
                $input['address'] = $request->address;
                $input['phone'] = $request->phone;
                $input['region'] = $request->region;
                $input['city'] = $request->city;
                $input['created_at'] = date('Y-m-d H:i:s');
                $input['user_id'] = $user_id;
                $input['type'] = 1;
                Address::insert($input);
            }*/
            Session::flash('success', 'User account updated Successfully!');
            return redirect('customer/account');

        } else {
            return redirect('customer/account')->withInput($request->all())->withErrors($validator->errors());
        }
        return redirect('/');
    }
    public function orders() {
        $user_id = Auth::user()->id;
        $model = Orders::join("order_products as op","orders.id","=","op.order_id")
                ->select("orders.*")
                ->selectRaw("SUM(op.quantity) as totalQuantity")
                ->where("orders.user_id","=",$user_id)
                ->groupby("orders.id")->orderby("orders.id","desc")->paginate(10);
        //dd($model);
        $statuses = Orders::$status;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
  
        return view('front.customers.orders',compact('model','statuses','symbol'));
    }
    public function details($id) {
      $user_id = Auth::user()->id;
       
      $model = Orders::getOrderById($id,$user_id);
      if($model['order']!='') {
       $statuses = Orders::$status;
       $order = $model['order'];
       $products = $model['products'];
       $status = '';
        if (array_key_exists($order->status, $statuses)) {
            $status = $statuses[$order->status];
        }
       $currency = Config::get("params.currencies");
       $symbol = $currency["PKR"]["symbol"];
       $billing = Address::getAddress($user_id,1);
       $delivery = Address::getAddress($user_id,2,$order->id);
       return view('front.customers.details',compact('model','billing','delivery','statuses','symbol','products','order','status'));
      }
      else
      {
          return redirect('/');
      }
    }
    public function ratings() {
        $user_id = Auth::user()->id;
        $model = Reviews::join("products as pro","pro.id","=","reviews.product_id")
                ->select("reviews.*","pro.name as productName")
                ->where("reviews.user_id","=",$user_id)
                ->groupby("reviews.id")->orderby("reviews.id","desc")->paginate(10);
  
        return view('front.customers.ratings',compact('model'));
    }
    public function changePassword() {
        $user_id = Auth::user()->id;
        return view('front.customers.change_password',compact('user_id'));
    }
    public function updatePassword(Request $request) {
        $user_id = Auth::user()->id;
        $rules = array(
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|min:6',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors());
        }
        $user = User::find($user_id);
        if(Hash::check($request->old_password, $user->password))
        {
            $data = $request->all();
            array_forget($data, 'password_confirmation');
            array_forget($data, 'old_password');
            array_forget($data, '_token');
            $data['password'] = bcrypt($request->password);
            $user->update($data);
            Session::flash('success', 'Your password has been changed.');
            return redirect('customer/password');
        }

        Session::flash('danger', 'Old password is Incorrect.');
        return redirect('customer/password');
        
    }
    

}
