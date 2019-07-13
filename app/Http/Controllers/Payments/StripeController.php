<?php

namespace App\Http\Controllers\Payments;

use Session;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect;
use App\Functions\Functions;
use Illuminate\Http\Request;
use App\StripeAccounts;
use Auth;
class StripeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function redirect(Request $request) {

        $user_id = Auth::user()->id;
        $accountId = $request->code;
        $account = StripeAccounts::where('user_id', $user_id)->first();
        $date=date('Y-m-d H:i:s');
        if (count($account) == 0) {

            StripeAccounts::insertGetId(array('user_id' => $user_id, 'accountId' => $accountId,'created_at'=>$date));
        } else {
            StripeAccounts::where('id', $account->id)->update(array('accountId' => $accountId,'updated_at'=>$date));
        }
        d($request->all(),1);
    }
    public function cancel() {
        
    }

}
