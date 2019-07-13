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
use App\DiscountCoupons;
use App\Content;

class CartController extends Controller {

    private $sessionId;
	
    public function __construct()
    {
	  session_start();
	  $this->sessionId=session_id();
    } 

    public function index() {
       
       $session_id = $this->sessionId;
       $cart = Cart::getCart($session_id); 
       $validDiscount = Session::get('validDiscount');
       $currency = Config::get("params.currencies");
       $symbol = $currency["PKR"]["symbol"];
       if ($validDiscount == 1) {
            $coupon = Session::get('coupon');
        }
        $pageTitle = 'Cart';
        $shipping_rates  = Content::getShipping();
        return view('front.cart.index', compact('cart', 'coupon','symbol','pageTitle','validDiscount','coupon','shipping_rates'));
    }

    public function store(Request $request) {
        
        if($request->ajax())
        {
            $id = $request->id;
            $sizeId = $request->sizeId;
            if(!empty($id))
            {
                $model = Products::find($id);
                if(count($model)>0)
                {
                    $session_id = $this->sessionId;
                    $checkCarProduct= Cart::where("session_id","=",$session_id)
                    ->where("product_id","=",$id)->where("productsize_id","=",$sizeId)->first();  
                    if(count($checkCarProduct)>0)
                    {
                        if($checkCarProduct->quantity>=10)
                        {
                            $message = '<span class="name">Not enough item stock</span>';
                            return response(['message' => $message, 'status' => 'error']); 
                        }
                        elseif($checkCarProduct->quantity>$model->quantity)
                        {
                            $message = '<span class="name">Not enough item stock</span>';
                            return response(['message' => $message, 'status' => 'error']); 
                        }
                        else {
                        $unitPrice = ($model->sale_price!=0)?$model->sale_price:$model->price;
                        $cartId = $checkCarProduct->id;
                        $quantity = $checkCarProduct->quantity+1;
                        $totalPrice = $unitPrice*$quantity;
                        Cart::where("id","=",$cartId)->update(["quantity"=>$quantity,"totalPrice"=>$totalPrice]); 
                        }
                    }
                    else
                    {
                        $unitPrice = ($model->sale_price!=0)?$model->sale_price:$model->price;
                        $cart = new Cart;
                        $cart->product_id = $id;
                        $cart->session_id = $this->sessionId;
                        $cart->productsize_id = $sizeId;
                        $cart->quantity = 1;
                        $cart->unitPrice = $unitPrice;
                        $cart->totalPrice = $unitPrice;
                        $cart->save();
                        $cartId = $cart->id;   
                    }
                    $currency = Config::get("params.currencies");
                    $symbol = $currency["PKR"]["symbol"];
                    $message = '<span class="name">'.$model->name.'</span><br/> 
                                <span class="price"><span data-currency-iso="PKR">'.$symbol.'.</span> 
                                <span dir="ltr">'.Functions::moneyFormat($unitPrice).'</span> </span><br/> 
                                <span class="addedToCart">Item added to Cart</span>';
                    return response(['message' => $message, 'status' => 'success']); 
                    
                }
            } 
        }
    }
    public function show(Request $request) {
        
        if($request->ajax())
        {
            $cartItems = Cart::countItems($this->sessionId);
            if(count($cartItems)>0)
            {
                echo $cartItems;
            }
            else {
                
                echo 0;
            }
        }
    }
    public function delete($id){
        Cart::find($id)->delete();
        return redirect('/cart')->with("success","Product was removed from cart");
    }
    public function update(Request $request) {
        $post = $request->all();

        foreach ($post['qty'] as $id => $qty) {

            if ($qty <= 0) {
                continue;
            }
            $cart = Cart::find($id);
            if(count($cart)>0)
            {
                $input['quantity'] = $qty;
                $input['totalPrice'] = $cart->unitPrice*$qty;
                $affectedRows = Cart::where('id', '=', $id)->update($input);
            }
            
        }
        return redirect('cart')->with("success","Your cart has been updated");
    }
    public function apply(Request $request) {
        
        $coupon=DiscountCoupons::where("code","=",$request->coupon)->first();
        
        $now=time();
        $valid=true;
        //strtotime(date($coupon->endDate));
        if(empty($coupon))
        {
           $valid=false;
           \Session::flash('error', 'Sorry! Coupon is not found.');  
        }
//        elseif($coupon->used>=$coupon->maxUse)
//        {
//            $valid=false;
//           \Session::flash('error', 'Sorry! Coupon is used up.');  
//        }
        elseif($now>=strtotime(date($coupon->endDate)))
        {
            $valid=false;
            \Session::flash('error', 'Sorry! this coupon is expired.'); 
        }
        elseif($now<strtotime(date($coupon->startDate)))
        {
            $valid=false;
            \Session::flash('error', 'Please! apply this coupon on '.date("d F Y",strtotime(date($coupon->startDate)))." and onwards."); 
        }
        elseif($request->subTotal<$coupon->minOrder)
        {
            $valid=false;
            \Session::flash('error', 'You order should be minimum Rs'.$coupon->minOrder.'.');   
        }
        if($valid==true)
        {
            Session::forget('coupon');
            Session::forget('validDiscount');
            $discount = 0;
            if($coupon->type==1){
                if($coupon->amount<=90) {
                    $discount = round($coupon->amount/100,0);
                }  
            }
            elseif($coupon->type==2){
               $discount = $coupon->amount;  
            }
            $data['type']=$coupon->type;
            $data['discount']=$discount;
            $data['amount']=$coupon->amount;
            $data['coupons']=$coupon;
            Session::put('coupon',$data);
            Session::put('validDiscount',1);
            return redirect("cart")->with("success","Discount coupon applied successfully!");
        }
        else
        {
            Session::put('validDiscount',0);
            return redirect("cart");
        }
        //return redirect('cart')->with("success","Discount applied successfully!");
    }
    public function remove(Request $request) {
        Session::forget('coupon');
        Session::forget('validDiscount');
        return redirect("cart")->with("success","Discount coupon removed successfully!");
    }


}
