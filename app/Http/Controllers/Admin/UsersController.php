<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use DB;
use Excel;
use Validator,
    Redirect;
use Session;
use App\Comments;
use Illuminate\Http\Request;

class UsersController extends AdminController 
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $model = User::searchUser('');
        $status = User::$status;
        $colors = User::$colors;
        return view('admin.users.index', compact('model','status','colors'));
    }

    public function search(Request $request) {
        // d($request->all(),1);
        $data['search'] = $request->all();
        $model = User::searchUser($data['search']);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('admin.users.ajax.list',compact('model','statuses','colors'));
    }
    
    public function show(Request $request, $id) {
       
    }
    public function create() {
        $status = User::$status;
        return view('admin.users.create', compact('status'));
    }
    public function store(Request $request) {
        
        $validation = array(
            'firstName' => 'required|max:50',
            'lastName' => 'max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',

            );
       
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator->errors())->withInput();
          
        }
        else
        {
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
            $user->role_id = 2;
            $user->save();

            \Session::flash('success', 'User Added Successfully!');
            return redirect('admin/users');
        }
      
       
    }
    public function edit($id) {
        $model = User::find($id);
        $status = User::$status;
        return view('admin.users.edit', compact('model','status'))->with('id', $id);
    }

    public function update(Request $request, $id) {
       
        $user = User::find($id);
        $input = $request->all();
        $validation = array(
            'firstName' => 'required|max:50',
            'lastName' => 'max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,

            );
        if($input["password"]!='')
        {
            $validation[] = array(
            'password' => 'required|confirmed|min:6',
            );
        }
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator->errors())->withInput();
          
        }
        else
        {
            unset($input['_method']);
            unset($input['_token']);
            if($input["password"]!=''){
                unset($input['password_confirmation']);
                $input['password'] = bycrpt($request->password);
            }
            else {
                unset($input['password']);
                unset($input['password_confirmation']);      
            }   
            User::where('id', '=', $id)->update($input);
            Session::flash('success', 'User Updated Successfully!');
            return redirect('admin/users');
        }
    }

    public function destroy($id){
        User::destroy($id);
        Session::flash('success', 'User Deleted Successfully !');
        return redirect()->back();
    }

}
