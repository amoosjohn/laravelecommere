<?php

namespace App\Http\Controllers;

use Auth;
use App\Role;

class VendorController extends Controller {

    public function __construct() {
        //session_start();
        //$this->middleware('auth');


        //self::checkRole();
    }

    public static function checkRole() {
        if (isset(Auth::user()->id)) {
            $role = Role::find(Auth::user()->role_id);
            if ($role->role != 'vendor') {
                header("Location:" . url(''));
                die;
            }
        } else {
            header("Location:" . url('/'));
            die;
        }
    }

}

