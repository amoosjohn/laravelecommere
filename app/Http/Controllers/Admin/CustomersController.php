<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
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
use App\Orders;

class CustomersController extends AdminController
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
        $model = User::searchUser('',6);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('admin.customers.index', compact('model','statuses','colors'));
    }
    public function show($id) {
        $model = User::where('users.id', '=', $id)
                ->leftJoin("regions as r", "users.region", "=", "r.id")
                ->leftJoin("cities as c", "users.city", "=", "c.id")
                ->select("users.*","r.name as regionName", "c.name as cityName")
                ->first();
        if(count($model)>0) {
        $statuses = User::$status;
        $colors = User::$colors;
        $status = '';
        $color = '';
        if (array_key_exists($model->status, $statuses)) {
            $status = $statuses[$model->status];
        }
        if (array_key_exists($model->status, $colors)) {
            $color = $colors[$model->status];
        }

        $orders = Orders::search('','',$id);
        $statuses = Orders::$status;
        $colors = Orders::$colors;
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        
        return view('admin.customers.show', compact('model','orders','statuses','colors','symbol','status','color'));
        }
        else {
            return redirect('/');
        }
    }
    public function search(Request $request)
    {
        $data['search'] = $request->all();
        $model = User::searchUser($data['search'],6);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('admin.customers.ajax.list',compact('model','statuses','colors'));
            
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
        $model = User::with("users")->with("products")->find($id);
        $status = User::$status;
        return view('admin.customers.edit', compact('model','status'))->with('id', $id);
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
        $user = User::find($id);
        if(count($user)>0)
        {
            if($user->status==2 || $user->status==0) {
                
                User::where("id","=",$id)->update(array('status'=>1));

            }
            elseif($user->status==1) {
                User::where("id","=",$id)->update(array('status'=>2));
            }
            \Session::flash('success', 'Status updated Successfully!');
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
        $row = User::where("id","=",$id)->forceDelete();
        \Session::flash('success', 'Customer Deleted Successfully!');
        return redirect('admin/customers');
    }
}
?>