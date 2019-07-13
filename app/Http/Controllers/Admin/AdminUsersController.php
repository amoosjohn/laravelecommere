<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Auth;
use App\Tasks;
use App\User;
use Validator;
use App\ProfileUpdates;
use Illuminate\Http\Request;

class AdminUsersController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (Auth::user()->role->role == 'admin') {

            $model = User::where('role_id', '=', 1)
                    ->leftJoin('roles as r', 'r.id', '=', 'users.role_id')
                    ->select('users.id', 'users.firstName', 'users.lastName', 'users.email', 'users.role_id', 'users.created_at', 'r.role')
                    ->orderBy('id','desc')
                    ->paginate(10);
            return view('admin.admin-users.index', compact('model'));
        } else {
            return redirect('home');
        }
    }

    public function create() {
        if (Auth::user()->role->role == 'admin') {
            return view('admin.admin-users.create');
        } else {
            return redirect('home');
        }
    }

    public function store(Request $request) {
        $validation = array(
            'firstName' => 'required|max:20',
            'lastName' => 'required|max:20',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
                //'g-recaptcha-response' => 'required|recaptcha',
        );
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = bcrypt($request->password);
        $user->status = 1;
        $user->save();
        ProfileUpdates::updateProfile($request->all());
        \Session::flash('success', 'Added Successfully!');
        return redirect('admin/admin-users');
    }

    public function userDetail(Request $request, $id) {
        $userId = $request->id;
        if ($userId > 0) {
            if (Auth::user()->role->role == 'admin') {

                $data = User::where('users.id', '=', $userId)->get();

                $model = Tasks::where('user_id', '=', $userId)
                        ->where('status', '=', 1)
                        ->where('deleted', '=', 0)
                        ->paginate(10);
                return view('admin.admin-users.details', [
                    'data' => $data,
                    'model' => $model,
                ]);
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }
}
