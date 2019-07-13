<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Auth,Config;
use Illuminate\Http\Request;
//use App\Functions\Functions;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
//use Mbarwick83\TwitterApi\TwitterApi;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Abraham\TwitterOAuth\TwitterOAuth;
use App\Functions\Functions;
use App\Urls;
use App\Cities;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input; 
use App\Cart;
use App\Content;

class SignupController extends Controller {

    
    use AuthenticatesUsers;
    //public function __construct(Guard $auth, Registrar $registrar) {
    public function __construct() {
     
      //$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
      
    }

    public function login() {
        return view('front.customers.login');
    }

    public function adminlogin() {
        return view('admin.admin_login');
    }

    public function vendorlogin() {
        //return 'this is vendor login ';
        return view('vendors.vendor_login');
    }

    public function signupform() {
        return view('front.customers.signupform');
    }

    public function loginform() {
        return view('front.customers.login_form');
    }

    public function vendorSignup() {
        $regions = Cities::regions();
        return view('front.vendor.signup',compact('regions'));
    }

    public function register() {
        $pathInfo = (explode("/", $_SERVER['REQUEST_URI']));
        $view = 'front.customers.register_' . end($pathInfo);
        return view($view, compact('specialities'));
    }

    public function fblogin(Request $request) {
        session_start();
        $user = User::where('email', $request->email)->first();
        $response = array();
        if (count($user) == 0) {

            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->role_id = 2;
            $user->joinFrom = $request->joinFrom;
            $user->isConfirmed = 1;
            $user->status = 1;
            $user->password = 1;
            $user->save();
        }
        $response['login'] = false;
        if (Auth::loginUsingId($user->id)) {

            $sessionId = session_id();
            $response['login'] = true;
            $response['id'] = $user->id;
            $redirect = $this->redirect;
            $response['redirect'] = $redirect;
        }
        echo json_encode($response);
    }

    
    public function forgot_password() {
        return view('front.customers.forgot');
    }

    public function postLogin(Request $request) {
        //$loginPath = '';
        $this->validate($request, [
            'email' => 'required|email|max:50|exists:users,email,status,1',
            'password' => 'required|string|min:6',
        ]);
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session_start();
            $role = Auth::user()->role->role;
           
            if ($role == 'admin') {

                return redirect('admin');
            }

            if ($role == 'vendor') {
           
                return redirect('vendor');
            }
            if ($role == 'customer') {
                $sessionId=session_id();
                $cart = Cart::countItems($sessionId);
                if($cart>0){
                    return redirect('/checkout');
                }
                return redirect('customer/dashboard');
            }
        }
        return redirect()->back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            $this->username() => trans('auth.failed'),
        ]);
        //if ($request->role_id == 1 || $request->role_id == 2) {
            //$loginPath = 'admin/login';
        //} else if ($request->role_id == 3) {
        //$loginPath = 'vendor/login';
        //}
        
    }
    public function signup() {
        return view('front.customers.signup');
    }
    public function store(Request $request) {
        //dd($request);
        $validation = array(
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'gender' => 'required|max:10',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
        );
        $validator = Validator::make($request->all(), $validation);
        $response['error'] = 0;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        }

        if ($request->ajax() == 1) {
            $response['token'] = csrf_token();
            echo json_encode($response);
            die;
        }
        if ($response['error'] == 0) {
            
            $dob = $request->date.'-'.$request->month.'-'.$request->year;
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->gender = $request->gender;
            $user->dob = $dob;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->role_id = 6;
            $user->remember_token = bcrypt(time());
            $user->newsletter = (isset($request->newsletter))?$request->newsletter:0;
            $user->save();
            
            session_start();
            $sessionId = session_id();
            $cart = Cart::countItems($sessionId);
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->has('remember'))) {
                $content = Content::where('code', '=', 'customer_signup')->get();
                $replaces = array();
                $template = Functions::setEmailTemplate($content, $replaces);
                $subject = $template["subject"];
                $body = $template["body"];
                $send_email = Functions::sendEmail($request->email, $subject, $body, '', Config::get('params.from_email'));
                if ($cart > 0) {
                    return redirect('/checkout');
                }
                else {  
                    Session::flash('success', 'Thanks for signing up!');
                    return redirect()->intended('/customer/dashboard');
                } 
            }
        } else {
            return redirect('signup')->withInput($request->all())->withErrors($validator->errors());
        }
        return redirect('/');
    }

    public function success($id) {
        $this->middleware('auth');
        $user = User::findOrFail($id);
        $data['user'] = $user;
        return view('front.customers.register_success', $data);
    }
    public function vendorRegister(Request $request) {
        
        $validation = array(
            'companyName' => 'required|max:100|unique:users,firstName',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
            'address' => 'required|max:500',
            'postal_code' => 'required|numeric',
            'region' => 'required|numeric',
            'city' => 'required|numeric',
            'mobile' => 'required|numeric',
            'logo' => 'mimes:jpeg,bmp,png,gif,jpg',
            'contactPerson' => 'max:100',
            'designation' => 'max:100',
            
        );
        if($request->contactemail!='') {
            $validation['contactEmail'] = 'email|max:50|unique:users,email';
        }
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        else
        {
          $users = User::select('*')->where('email','=',$request->contactemail)->get();
          if(count($users)==1)
          {
            return redirect()->back()->withInput($request->all())->withErrors('Contact Email Already Exist');
              
          }
          else
          {
            if($request->email==$request->contactEmail){
                \Session::flash('danger', 'Vendor email and contact email cannot be same!');
                return redirect()->back()->withInput($request->all());
            }   
            //insert VENDOR detail
            $imageName = '';
            if (Input::hasFile('logo')) 
            {
                $imageTempName = $request->file('logo')->getPathname();
                $imageName = $request->file('logo')->getClientOriginalName();
                $path = public_path() . '/uploads/vendors_logo/';
                $request->file('logo')->move($path , $imageName);
            }
            $user = new User;
            $user->firstName = $request->companyName;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->postal_code = $request->postal_code;
            $user->city = $request->city;
            $user->region = $request->region;
            $user->mobile = $request->mobile;
            $user->status = 2;
            $user->logo = $imageName;
            $user->role_id = 3;//$request->role_id;
            $user->status = 0;
            $user->contactPerson = $request->contactPerson;
            $user->designation = $request->designation;
            $user->save();
            $vendor_id=$user->id;
//            
//            if($request->contactEmail!='') {
//                $user = new User; 
//                $user->firstName = $request->firstName;
//                $user->email = $request->contactEmail;
//                $user->address = $request->contactaddress;
//                $user->mobile = $request->contactMobile;
//                $user->role_id = 5; 
//                $user->vendor_id = $vendor_id; 
//                $user->status = 2;
//                $user->save();
//            }
            $key = Functions::slugify($request->companyName);
            $random = Functions::generateRandomString(2,1);
            $input = array();
            $input['type_id'] = $vendor_id;
            $input['key'] = $key.'-'.$random;//.'-'.$model->id
            $input['type'] = 'vendor';
            $url = Urls::saveUrl($input);
            
            $content = Content::where('code', '=', 'vendor_signup')->get();
            $replaces = array();
            $template = Functions::setEmailTemplate($content, $replaces);
            $subject = $template["subject"];
            $body = $template["body"];
            $send_email = Functions::sendEmail($request->email, $subject, $body, '', Config::get('params.from_email'));


            \Session::flash('success', 'Your information has been submitted waiting for admin approval!');
            return redirect('vendor/signup');
          }
             
        }
    }

}
