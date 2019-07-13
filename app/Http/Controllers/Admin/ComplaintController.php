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
use App\Products;
use App\Complaint;
use App\Content;


class ComplaintController extends AdminController
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
        $model = Complaint::with("users")->orderBy("id","desc")->paginate(10);
        $statuses = Complaint::$status;
        $colors = Complaint::$colors;
        $types = Complaint::$types;
        return view('admin.complaint.index', compact('model','statuses','colors','types'));
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
        $model = Complaint::search('','');
        $statuses = Complaint::$status;
        $colors = Complaint::$colors;
        
        if ($request->ajax()) {
            return view('admin.complaint.search',compact('model','symbol','statuses','colors'))->render();  
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
        $model = Complaint::with("users")->find($id);
        $status = Complaint::$status;
        return view('admin.complaint.edit', compact('model','status'))->with('id', $id);
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
            'comments' => 'max:500',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
        $model = Complaint::find($id);
        $input = $request->all();
        unset($input["_method"]);
        unset($input["_token"]);
        $input["resolvedBy"] = Auth::user()->id;
        $model = Complaint::where("id","=",$id)->update($input);
        if($request->status==1) {
            $model = Complaint::find($id);
            $content = Content::where("code","=","complaint")->get();
            $email = $model->email;
            $replaces['ID'] = $id;
            $replaces['NAME'] = $model->name;
            $replaces['TYPE'] = $model->type;
            $replaces['DETAILS'] = $model->details;
            $replaces['STATUS'] = $model->status;
            $replaces['COMMENTS'] = $model->comments;
            $template = Functions::setEmailTemplate($content, $replaces);
            $subject = $template["subject"];
            $body = $template["body"];
            $send_email = Functions::sendEmail($email, $subject, $body, '');
        }

        \Session::flash('success', 'Complaint Updated Successfully!');
        return redirect('admin/complaint');
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
        $row = Complaint::find($id)->delete();
        \Session::flash('success', 'Complaint Deleted Successfully!');
        return redirect('admin/complaint');
    }
}
?>