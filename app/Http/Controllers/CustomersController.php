<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect;
use App\User;
use App\Categories;
use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class CustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    use AuthenticatesAndRegistersUsers;

    public function __construct() {
        $this->middleware('auth');
    }

//    public function profile1() {
//        
//        
//        return view('front.sensaicorner');
//    }

    public function changepassword() {


        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        $breadcrumbs[0]['url'] = url('/');
        $breadcrumbs[0]['name'] = "Home";

        $breadcrumbs[2]['url'] = "#_";
        $breadcrumbs[2]['name'] = "My Games";

        $data['breadcrumbs'] = $breadcrumbs;
        $data['user_id'] = $user_id;
        //die('sadasd');	   
        return view('front.customers.change_password', $data);
    }

    public function index() {
        $data = array();
        $data['categories'] = Categories::join('urls as u', 'u.type_id', '=', 'categories.id')
                        ->select('categories.*', 'u.key')
                        ->where('parent_id', 0)->get();
        //d($data['categories'],1);
        return view('front.categories.index', $data);
    }

    public function postchangepassword(Request $request) {
        $user_id = Auth::user()->id;
        $rules = array(
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors());
        }

        $user = User::findOrFail($user_id);

        //if(bcrypt($request->old_password) == $user->password)
        //{
        $data = $request->all();
        array_forget($data, 'password_confirmation');
        array_forget($data, 'old_password');
        array_forget($data, '_token');
        $data['password'] = bcrypt($request->password);

        $user->update($data);
        Session::flash('success', 'Your password has been changed.');
        return redirect()->back();
        //}


        Session::flash('error', 'Old password is Incorrect.');
        return redirect()->back()->withError('Incorrect old password', 'changepassword');
    }

    public function profile() {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        if (isset($user->dob)) {
            list($year, $month, $date) = explode('-', $user->dob);
            $user->day = $date;
            $user->month = $month;
            $user->year = $year;
        }

        $breadcrumbs[0]['url'] = url('/');
        $breadcrumbs[0]['name'] = "Home";

        $breadcrumbs[2]['url'] = "#_";
        $breadcrumbs[2]['name'] = "My Profile";

        $data['breadcrumbs'] = $breadcrumbs;
        $data['user_id'] = $user_id;
        $data['user'] = $user;
        //die('sadasd');

        return view('front.customers.profile', $data)->with('user_id', $user_id);
    }

    public function updateprofile(Request $request) {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        $rules = array(
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|min:6|email|unique:users,email,' . $user->id,
        );

        $validator = Validator::make($request->all(), $rules);

        // $checkEmail=User::where('email','!=',$user->email)->where('email',$request->email)->count();

        if ($validator->fails()) {
            // return Redirect::back()->withErrors($validator, 'register')->withInput();
            return Redirect::back()->withErrors($validator, 'errors')->withInput();
        } else {

            $data = $request->all();
            $input['email'] = $request->email;
            $input['firstName'] = $request->firstName;
            $input['lastName'] = $request->lastName;
            $input['title'] = $request->title;
            array_forget($data, '_token');

            $affectedRows = User::where('id', '=', $user_id)->update($input);
            Session::flash('success', 'Your profile has been updated.');
            return redirect()->back();
        }
    }

}
