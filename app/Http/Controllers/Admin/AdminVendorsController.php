<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Auth,Config;
use App\User;
use Validator,
    Input,
    Redirect;
use App\Cities;
use Illuminate\Http\Request;
use App\Urls;
use App\Functions\Functions;
use File;
use App\Content;


class AdminVendorsController extends AdminController {

    public function index() {
        $model = User::searchUser('',3);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('admin.vendors.index',  compact('model','statuses','colors'));
    }
    public function search(Request $request)
    {
        $data['search'] = $request->all();
        $model = User::searchUser($data['search'],3);
        $statuses = User::$status;
        $colors = User::$colors;
        return view('admin.vendors.ajax.list',compact('model','statuses','colors'));
            
    }
    public function create() {
        
        $status = User::$status;
        $regions = Cities::regions();
        return view('admin.vendors.create', compact('status','regions'));
      
        
    }

 
    public function store(Request $request) {
        
        //
        $validation = array(
            'firstName' => 'required|max:50',
            //'lasttname' => 'required|max:20',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
            'address' => 'required|min:6',
            'postal_code' => 'required',
            'city' => 'required',
            'region' => 'required',   
            'mobile' => 'required',
            'logo' => 'mimes:jpeg,bmp,png,gif,jpg',
            'status' => 'required|max:1',
            'contactPerson' => 'max:100',
            'designation' => 'max:100',
            
        );
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        else
        {
           $users = User::select('*')->where('email','=',$request->contactemail )->get();
          
          if(count($users)==1)
          {
            return redirect()->back()->withInput($request->all())->withErrors('Contact Email Already Exist');
              
          }
          else
          {
            if($request->email==$request->contactemail){
                \Session::flash('danger', 'Vendor email and contact email cannot be same!');
                return redirect()->back()->withInput($request->all());
            }   
            //d($request->all(),1);
            //insert VENDOR detail
            $user = new User;
            $imageName = '';
            if (Input::hasFile('logo')) 
            {
                $imageTempName = $request->file('logo')->getPathname();
                $imageName = $request->file('logo')->getClientOriginalName();
                $path = public_path() . '/uploads/vendors_logo/';
                $request->file('logo')->move($path , $imageName);
            }
            $user->firstName =  $request->firstName;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->postal_code = $request->postal_code;
            $user->city = $request->city;
            $user->region = $request->region;
            $user->mobile = $request->mobile;
            $user->logo = $imageName;
            $user->role_id = 3;
            $user->status = $request->status;
            $user->contactPerson = $request->contactPerson;
            $user->designation = $request->designation;
            $user->save();
            $vendor_id=$user->id;
            $key = Functions::slugify($request->firstName);
            $random = Functions::generateRandomString(2,1);
            $input = array();
            $input['type_id'] = $vendor_id;
            $input['key'] = $key.'-'.$random;//.'-'.$model->id
            $input['type'] = 'vendor';
            $url = Urls::saveUrl($input);
            /*if($request->firstName!='') {
                $user = new User;
                $user->firstName = $request->firstName;
                $user->email = $request->contactemail;
                $user->address = $request->contactaddress;
                $user->mobile = $request->contactmobile;
                $user->role_id = 5;
                $user->vendor_id = $vendor_id;
                $user->status = $request->status;
                $user->save();
            }*/
            
            

            \Session::flash('success', 'Vendor Added Successfully!');
            return redirect('admin/vendors');
          }
             
        }
    }

   
    public function userDetail($id) {
        
        $vendor['vendor_detail'] = User::with("cities")->with("regions")->find($id);
        $vendor_con = User::where('vendor_id', '=',$id)->get();
        $vendor['vendor_contacts'] =  $vendor_con;
                  
        return view('admin.vendors.details',$vendor);
    }

    public function edit($id) {
        $details = User::find($id);
        $status = User::$status;
        $regions = Cities::regions();
        return view('admin.vendors.edit', ['model' => $details,'status' => $status,'regions' => $regions]);
    }

    public function update($id, Request $request) {
        //
         $validation = array(
            'firstName' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $id,
            'address' => 'required|min:6',
            'postal_code' => 'required',
            'city' => 'required',
            'region' => 'required',   
            'mobile' => 'required',
            'status' => 'required|max:1',
            'contactPerson' => 'max:100',
            'designation' => 'max:100',
        );
        if($request->password!=''){
            $validation['password'] = 'required|confirmed|min:6';
        }     
        if($request->logo!=''){
            $rules['logo'] =  'mimes:jpeg,bmp,png,gif,jpg';
        }
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        else
        {   
             //d('success', 1);
            $input = $request->all();
            $model = User::find($id);
            if (Input::hasFile('logo')) 
            {
                //$file = Input::file('image');
                $imageTempName = $request->file('logo')->getPathname();
                $imageName = $request->file('logo')->getClientOriginalName();
                $path = public_path() . '/uploads/vendors_logo/';
                $request->file('logo')->move($path , $imageName);
               $input['logo'] = $imageName;
            }
            
            array_forget($input, '_token');
            array_forget($input, 'password_confirmation');
            $input['password'] =  bcrypt($request->password);
            if($request->password==''){
                unset($input['password']);
                unset($input['password_confirmation']);
            }
            User::where('id', '=', $id)->update($input);
            if($request->firstName != $model->firstName) {
                $random = Functions::generateRandomString(2,1);
                $key = Functions::slugify($request->firstName);
                $input = array();
                $input['type_id'] = $id;
                $input['key'] = $key.'-'.$random;//.'-'.$model->id
                $input['type'] = 'vendor';
                $url = Urls::saveUrl($input);
            }
            
            \Session::flash('success', 'Info Updated Successfully!');
            return redirect('admin/vendors');
        }
    }

  
    public function destroy($id) {
        //
        User::find($id)->delete();
        \Session::flash('success', 'Deleted Successfully!');
        return redirect('admin/vendors');
    }
    public function status($id) {
        
        $user = User::find($id);
        if(count($user)>0)
        {
            if($user->status==2 || $user->status==0) {
                
                
                $url = Urls::getUrl($id,'vendor');
                $folder = $url->key;
                $path = public_path('uploads/products/' . $folder);
                $storage = File::makeDirectory($path, 0777,true,true);
                File::makeDirectory($path.'/thumbnail', 0777,true,true);
                File::makeDirectory($path.'/medium', 0777,true,true);
                File::makeDirectory($path.'/large', 0777,true,true);
                User::where("id","=",$id)->update(array('status'=>1));
                $content = Content::where('code', '=', 'vendor_login_approval')->get();
                $replaces = array();
                $template = Functions::setEmailTemplate($content, $replaces);
                $subject = $template["subject"];
                $body = $template["body"];
                $send_email = Functions::sendEmail($user->email, $subject, $body, '', Config::get('params.from_email'));
            }
            elseif($user->status==1) {
                User::where("id","=",$id)->update(array('status'=>0));
            }
            \Session::flash('success', 'Status updated Successfully!');
            return redirect('admin/vendors');
        } 
    }

}
