<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect,Config,Session;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Urls;
use App\Functions\Functions;
use App\Colours;
use App\ProductSize;
use App\Products;
use App\Cart;
use App\CartProductSize;
use App\Cities;
use App\Guests;
use App\Orders;
use App\OrderProducts;
use App\Content;
use App\User;
use App\OrdersDiscounts;

class CheckoutController extends Controller {

    private $sessionId;
	
    public function __construct()
    {
	  session_start();
	  $this->sessionId=session_id();
    } 

    public function index() {
       $session_id = $this->sessionId;
       $cart = Cart::getCart($session_id);
       if(count($cart)>0) {
           $pageTitle = 'Checkout';
            if (isset(Auth::user()->id)) {
                $user_id = Auth::user()->id;
                $user = User::find($user_id);
            }
            $currency = Config::get("params.currencies");
            $symbol = $currency["PKR"]["symbol"];
            $regions = Cities::regions();
            $validDiscount = Session::get('validDiscount');
            if ($validDiscount == 1) {
                $coupon = Session::get('coupon');
            }

            return view('front.checkout.index', compact('cart', 'symbol', 'regions', 'user', 'pageTitle', 'coupon'));
        }
        else {
            return redirect('/');
        }
       
    }
    public function cities(Request $request) {
        
        if($request->ajax())
        {
            $region = $request->region;
            $city = (isset($request->city))?$request->city:'';
           
            if ($region != "") {
                $cities = Cities::getCities($region);

                if (count($cities) > 0) {
                    echo '<option value="">Select City*</option>';
                    foreach ($cities as $row) {
                        $selected = '';
                        if($city==$row->id)
                        {
                            $selected = 'selected';
                        }
                        echo '<option value="' . $row->id . '" '.$selected.'>'. $row->name . '</option>';
                    }
                }
                
            }
            else {
                    echo '<option value="">Select City*</option>';
            }
        }
    }
    
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|max:50|email',
            'mobile' => 'required|max:20',
            'region' => 'required|numeric',
            'city' => 'required|numeric',
            'notes' => 'max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else
        {
            DB::beginTransaction();
            try {
            $session_id = $this->sessionId;
            $subTotal = Cart::grandTotal($session_id);
            $grandTotal = $request->grandTotal;
            $input = $request->all();
            $user_id = (isset(Auth::user()->id))?Auth::user()->id:0; 
            $shipping = Content::getShipping();
            $model = new Orders;
            $model->user_id = $user_id; 
            $model->status = 1; 
            $model->subTotal = $subTotal;
            $model->grandTotal = $grandTotal;
            $model->paymentType = 'Cash on Delivery';
            $model->paymentStatus = 1;
            $model->emailConfirmation = 1;
            $model->shipAddress = ($request->shipAddress!='')?$request->shipAddress:'1';
            $model->notes = $request->notes;
            $model->shipping = $shipping;
            $model->save();
            $id = $model->id;
            $validDiscount = Session::get('validDiscount');
            $discount = 0;
            if ($validDiscount == 1) {
                $coupon = Session::get('coupon');
                if (isset($coupon['coupons'])) {
                    $discount = $coupon['discount'];
                    if ($coupon['type'] == 1) {
                        $discount = $grandTotal * $discount;
                    }
                }
                $discountModel = new OrdersDiscounts();
                $discountModel->order_id = $id;
                $discountModel->user_id = $user_id; 
                $discountModel->coupon_id = $coupon['coupons']->id;
                $discountModel->discount = round($discount,0);
                $discountModel->save();
            }  
            
            OrderProducts::addProducts($session_id,$id);
            if(isset(Auth::user()->id)) {
                
                unset($input['_token']);
                unset($input['notes']);
                unset($input['shipAddress']);
                unset($input['grandTotal']);
                unset($input['email']);
                User::where("id","=",$user_id)->update($input);
            }
            else {
                unset($input['_token']);
                unset($input['notes']);
                unset($input['shipAddress']);
                unset($input['grandTotal']);
                unset($input['mobile']);
                $input['order_id'] = $id;
                $input['created_at'] = date('Y-m-d H:i:s');
                $input['phone'] = $request->mobile;
                Guests::insert($input);
            }
            DB::commit();
//            $model = Orders::getOrderById($id);
//            if(count($model)>0) {
//                $order = $model['order'];
//                $email = $input['email'];
//                $products = $model['products'];
//                $statuses = Orders::$status;
//                $status = '';
//                if (array_key_exists($order->status, $statuses)) {
//                    $status = $statuses[$order->status];
//                }
//                $currency = Config::get("params.currencies");
//                $symbol = $currency["PKR"]["symbol"];
//                $subject = 'Customer Order Invoice';
//                $body = view('emails.welcome', compact('order', 'products', 'symbol', 'status'));
//                $send_email = Functions::sendEmail($email, $subject, $body, '');
//                $admin_email = Config::get("params.admin_email");
//                Functions::sendEmail($admin_email, $subject, $body, '');
//            }
            $email = $request->email;
            $content = Content::where('code', '=', 'order_confirmation')->get();
            $replaces = array();
            $replaces['orderNumber'] = $id;
            $template = Functions::setEmailTemplate($content, $replaces);
            $subject = $template["subject"];
            $body = $template["body"];
            $send_email = Functions::sendEmail($email, $subject, $body, '', Config::get('params.from_email'));
            Session::forget('coupon');
            Session::forget('validDiscount');
            return redirect('thank-you')->with('success',$id);
            }
            catch (Exception $e) {
                DB::rollBack();
                return redirect('cancel')->with('error',$e);
            }
            
        }
    }
    public function thankYou() {
      
       return view('front.thank_you');
    }
    

}
