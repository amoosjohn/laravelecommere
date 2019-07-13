<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Validator,
    Redirect,Config;
use DB;
use Auth;
use App\Payments;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use Illuminate\Support\Facades\Input;
use App\User;

class PaymentsController extends AdminController
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
        $model = Payments::search();
        $statuses = Payments::$status;
        $colors = Payments::$colors;
        $methods = Payments::$methods;
        $users = User::getVendors();
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        return view('admin.payments.index', compact('model','users','statuses','colors','methods','symbol'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
        $search = $request->all();
        $model = Payments::search($search);
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $statuses = Payments::$status;
        $colors = Payments::$colors;
        $methods = Payments::$methods;
        return view('admin.payments.search',compact('model','users','statuses','colors','methods','symbol'))->render();  
        }      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Payments::$status;
        $methods = Payments::$methods;
        $users = User::getVendors();

        return view('admin.payments.create', compact('status','methods','users'));
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
            'user_id' => 'required',
            'method' => 'required|numeric|min:1',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'receivedBy' => 'max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $input = $request->all();
        unset($input['_token']);
        $input['created_at'] = date('Y-m-d H:i:s');
        Payments::insert($input);

        \Session::flash('success', 'Payment Added Successfully!');
        return redirect('admin/payments');
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
        $model = Payments::findOrFail($id);
        $status = Payments::$status;
        $methods = Payments::$methods;
        $users = User::getVendors();
        return view('admin.payments.edit', compact('id','model','status','methods','users'));
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
        $model = Payments::find($id);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'method' => 'required|numeric|min:1',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'receivedBy' => 'max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        
        $id = $model->id;
        $input = $request->all();
        unset($input['_method']);
        unset($input['_token']);
        $affectedRows = Payments::where('id', '=', $id)->update($input);
        \Session::flash('success', 'Payment Updated Successfully!');
        return redirect('admin/payments');
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
         Payments::where('id',$id)->forceDelete();

         \Session::flash('success', 'Payment Deleted Successfully!');
        return redirect('admin/payments');
    }
}
