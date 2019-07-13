<?php

namespace App\Http\Controllers\Payments;

use Session;
use DB;
use App\Content;
use App\User;
use App\Orders;
use App\Address;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect;
use App\Cart;
use App\Functions\Functions;
use Illuminate\Http\Request;

class CheckController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $sessionId;

    public function __construct() {
        $this->middleware('auth');
        session_start();
        $this->sessionId = session_id();
    }

    public function success() {
        $order_id = Session::get('order_id');
        $orders = Orders::getOrderDetailByPk($order_id);
        
        $affectedRows = Orders::where('id', '=', $order_id)->update(array('paymentStatus' => 'check'));
        Cart::where('session_id', '=', $this->sessionId)->delete();
        $content = Content::where('code', '=', 'order_confirmation')->get();
        $replaces['NAME'] = $orders->name;
        $replaces['ID'] = Config("params.order_prefix").$order_id;
        $replaces['STATUS'] = "pending";
        $template = Functions::setEmailTemplate($content, $replaces);
        $mail = Functions::sendEmail($orders->email, $template['subject'], $template['body']);
        $content = Content::where('code', '=', 'check_success')->firstOrFail();
        return view('front.payments.check.success', compact('content','order_id'));
    }

    public function cancel() {
        $order_id = Session::get('order_id');
        $check = PayPal::where('order_id', '=', $order_id)->count();
        if ($check == 0) {
            $model = new PayPal();
            $model->token = $_GET['token'];
            $model->order_id = $order_id;
            $model->save();
            $affectedRows = Orders::where('id', '=', $order_id)->update(array('paymentStatus' => 'cancel'));
        }
        $content = Content::where('code', '=', 'paypal_cancel')->firstOrFail();
        return view('front.payments.paypal.cancel', compact('content'));
    }

}
