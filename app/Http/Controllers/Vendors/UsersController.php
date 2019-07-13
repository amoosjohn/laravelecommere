<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
use Validator,
    Redirect;
use DB;
use Auth;
use App\User;
use App\Urls;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Functions\Functions;
use App\Permissions;
use App\UsersPermissions;

class UsersController extends VendorController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Cafe's For Admin.
     */
    public function index()
    {
         $user_id = Auth::user()->id;
         $model = User::where('role_id', '=', 4)->where('vendor_id', '=', $user_id)->paginate(10);
         $statuses = User::$status;
         $colors = User::$colors;
         return view('vendors.users.index', compact('model','statuses','colors'));
    }
    
    public function create()
    {
        $status = User::$status;
        $permissions = Permissions::with('children')->where('parent_id', 0)->get();
        return view('vendors.users.create',compact('status','permissions'));
         
    }
    public function store(Request $request)
    {
        $validation = array(
            'firstName' => 'required|max:20',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
            'gender' => 'required',
            'mobile' => 'required',
            
        );
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        else
        {
            
            
            $user = new User;
            $user->firstName = $request->firstName;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->status = $request->status;
            $user->role_id = 4;
            $user->vendor_id = Auth::user()->id; 
            $user->save();
            $id = $user->id;
            $permissions = isset($request->permission_id)?$request->permission_id:null;
            
            $data = array();
            if(count($permissions)>0){
               
                foreach ($permissions as $permissionId) {
                    if($permissionId!='') {
                    $data[] = array('user_id' => $id, 'permission_id' => $permissionId,
                            'created_at' => date("Y-m-d H:i:s"));    
                    }
                }
                if(count($data)>0)
                {
                    UsersPermissions::insert($data);
                }
            }
            
            \Session::flash('success', 'Vendor User Added Successfully!');
            return redirect('vendor/users');
        }
    }
    
    public function edit($id)
    {
        $model = User::find($id);
        $status = User::$status;
        $permissions = Permissions::with('children')->where('parent_id', 0)->get();
        $userPermissions = UsersPermissions::where("user_id",$id)->get();
        return view('vendors.users.edit', compact('model','status','permissions','userPermissions'))->with('id', $id);
    }
    
    public function update($id, Request $request)
    {
        $user_id = $id;
        $user = User::findOrFail($user_id);
        $input = $request->all();
        $rules = array(
            'firstName' => 'required|max:50',
            'email' => 'required|min:6|email|unique:users,email,' . $user->id,
        );
        if($input["password"]!='')
        {
            $rules[] = array(
            'password' => 'required|confirmed|min:6',
            );
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } 
        else 
        {
            unset($input['_method']);
            unset($input['_token']);
            unset($input['permission_id']);
            if($input["password"]!=''){
                unset($input['password_confirmation']);
                $input['password'] = bycrpt($request->password);
            }
            else {
                unset($input['password']);
                unset($input['password_confirmation']);      
            }   
            User::where('id', '=', $id)->update($input);
            
            $permissions = isset($request->permission_id)?$request->permission_id:null;
            $data = array();
            if(count($permissions)>0){
                UsersPermissions::where('user_id',$id)->delete();
                foreach ($permissions as $permissionId) {
                    if($permissionId!='') {
                    $data[] = array('user_id' => $id, 'permission_id' => $permissionId,
                            'created_at' => date("Y-m-d H:i:s"));    
                    }
                }
                if(count($data)>0)
                {
                    UsersPermissions::insert($data);
                }
            }
            Session::flash('success', 'User Updated Successfully!');
            return redirect('vendor/users');
        }
        
    }
    
    public function delete($id)
    {
        User::destroy($id);
        Session::flash('success', 'User Deleted Successfully !');
        return redirect()->back();
    }

    

}
