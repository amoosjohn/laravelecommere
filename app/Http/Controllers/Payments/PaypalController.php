<?php 
namespace App\Http\Controllers\Payments;
use Session;
use DB;
use App\Paypal;
use App\Content;
use App\User;
use App\Orders;
use App\Address;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect; 
use App\Cart;
use App\Functions\Functions;

use Illuminate\Http\Request;

class PaypalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    private $sessionId;
    
	public function __construct()
	{
	  $this->middleware('auth');
	  session_start();
	  $this->sessionId=session_id();
    }
    
    public function success()
    {
      $order_id=Session::get('order_id');
      $check=Paypal::where('order_id','=',$order_id)->count();
      $orders= Orders::getOrderDetailByPk($order_id);
      $addresses = Address::where('order_id', $order_id)->orderBy('addressType','asc')->groupBy('addressType')->limit(2)
       ->leftJoin('countries as c', 'c.id', '=', 'address.id')
       ->select('address.*','c.name as country') 
       ->get();
      if($check==0)
      {
        $model=new Paypal();
        $model->paymentId=$_GET['PayerID'];
        $model->token=$_GET['token'];
        $model->payerID=$_GET['PayerID'];
        $model->order_id=$order_id;
        $model->save();
        $affectedRows = Orders::where('id','=',$order_id)->update(array('paymentStatus' => 'success'));
        Cart::where('session_id', '=', $this->sessionId)->delete();
        $content= Content::where('code','=','order_confirmation')->get();
      
        $replaces['NAME']=$orders->billingName;
          
        $template=Functions::setEmailTemplate($content,$replaces);
        $mail=Functions::sendEmail($orders->email,$template['subject'],$template['body']);
      }
      
      $content= Content::where('code','=','paypal_success')->firstOrFail();
      
      return view('front.payments.paypal.success',compact('content'));
    }
    
    public function cancel()
    {
        $order_id=Session::get('order_id');
        $check=PayPal::where('order_id','=',$order_id)->count();
        if($check==0)
        {
            $model=new PayPal();
            $model->token=$_GET['token'];
            $model->order_id=$order_id;
            $model->save();
            $affectedRows = Orders::where('id','=',$order_id)->update(array('paymentStatus' => 'cancel'));
        }
        $content= Content::where('code','=','paypal_cancel')->firstOrFail();
        return view('front.payments.paypal.cancel',compact('content'));
    }
}
