<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\User;
use Auth,Config;
use App\Categories;
use App\Products;
use App\Videos;
use Validator,
   Input,
    Redirect;
use Session;
use Illuminate\Http\Request;
use App\Functions\Functions;
use App\Orders;
use App\Cities;
use App\Urls;
use App\Permissions;
use App\BankAccount;

class HomeController extends VendorController {

    public function __construct() {
        session_start();
        $this->sessionId = session_id();
    }

    public function index() {
        $data = array();
        $user_id = Auth::user()->id;
        // $countProducts = Products::search('',$user_id,1);
        //$data['totalproducts'] = $countProducts->count();
        $data['totalproducts'] = Products::leftJoin("urls as u","products.id","=","u.type_id")->where('u.type', '=', 'product')->where('user_id', '=', $user_id)->where('products.status', '=', 1)->count();
        $data['totalOrders'] = Orders::search('',$user_id);
        $result = Orders::totalAmount($user_id,date('Y'));
        $data['totalSales'] = (count($result['sales']) > 0) ? $result['sales'] : 0;
        $data['totalPending'] = (count($result['pending']) > 0) ? $result['pending'] : 0;
        $sales = Orders::getSalesByMonth($user_id);
        //dd($sales);
        $chartData = '';
        if(count($sales)>0) {
            $count = 1;
        for($i=0;$i<12;$i++) {  
            $year = isset($sales[$i]['year'])?$sales[$i]['year']:date("Y");
            $month = isset($sales[$i]['month'])?$sales[$i]['month']:$count;
            $total = isset($sales[$i]['total'])?$sales[$i]['total']:0;
            
            $chartData .= "{ year:'".$year.'-'.$month."',total:".$total."}, ";
            $count++;
        }
        $chartData = substr($chartData, 0, -2);
        }
        
        
        $orders = Orders::getOrdersByMonth($user_id);
        
        $chartData2 = '';
        if(count($orders)>0) {
        $count = 1;
        for($i=0;$i<12;$i++) {  
            $year = isset($orders[$i]['year'])?$orders[$i]['year']:date("Y");
            $month = isset($orders[$i]['month'])?$orders[$i]['month']:$count;
            $total = isset($orders[$i]['count'])?$orders[$i]['count']:0;
            
            $chartData2 .= "{ year:'".$year.'-'.$month."',total:".$total."}, ";
            $count++;
        }
        $chartData2 = substr($chartData2, 0, -2);  
        }      
        
        //dd(json_encode($orders));
        $data['totalcontacts'] = User::where('role_id', '=', 3)->Where('vendor_id', '=', $user_id)->get();
         //total users 
        $data['totalUsers'] = User::where('role_id', '=', 4)->Where('vendor_id', '=', $user_id)->get();
      
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $year = date("Y");
       
        $permission = Permissions::getPermission($user_id,'monthly_sales');
        $permission2 = Permissions::getPermission($user_id,'monthly_orders');
        $permission3 = Permissions::getPermission($user_id,'product');
        $permission4 = Permissions::getPermission($user_id,'orders');
        session_regenerate_id();
        
        return view('vendors.index',$data,compact('permission','permission2','permission3','permission4','chartData','year','symbol','chartData2'));
    }
    
    public function view_profile()
    {
        $data = array();
        $user_id = Auth::user()->id;
        $data['myinfo']  = User::where('id', '=', $user_id)->get();
      
        return view('vendors.view_profile',$data);
        
    }
    public function edit_profile($id)
    {
         $data = array();
         $data['edit_info']  = User::with('bankaccount')->where('id', '=', $id)->first();
         $regions = Cities::regions();
         $bankNames = BankAccount::$bankNames;
         //dd($data['edit_info']);
         return view('vendors.edit_profile',$data,compact('bankNames','regions'));
    }
    
    public function update_profile($id, Request $request)
    {
        $user_id = $id;
        $user = User::findOrFail($user_id);
        $rules = array(
            'firstName' => 'required|max:20',
            'email' => 'required|email|max:50|unique:users,email,' . $id,
            'address' => 'required|min:6',
            'postal_code' => 'required',
            'city' => 'required',
            'region' => 'required',   
            'mobile' => 'required',
            'title' => 'required|max:20',
            'number' => 'required|max:50',
            'bankName' => 'required',
            'branchCode' => 'required|max:20',
        );
        if($request->password!=''){
            $rules['password'] = 'required|confirmed|min:6';
        }
        if($request->logo!=''){
            $rules['logo'] =  'mimes:jpeg,bmp,png,gif,jpg';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } 
        else 
        {
            $input = $request->all();
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
            unset($input['title']);
            unset($input['number']);
            unset($input['bankName']);
            unset($input['branchCode']);
            User::where('id', '=', $id)->update($input);
            $checkAccount = BankAccount::where('user_id', '=', $id)->first();
            $input = array();
            $input['title'] = $request->title;
            $input['number'] = $request->number;
            $input['bankName'] = $request->bankName;
            $input['branchCode'] = $request->branchCode;
            if(count($checkAccount)>0) {
                BankAccount::where('id', '=', $checkAccount->id)->update($input);
            }
            else {
                $input['user_id'] = $id;
                $input['created_at'] = date('Y-m-d H:i:s');
                BankAccount::insert($input);
            }
            $key = Functions::slugify($request->firstName);
            $input = array();
            $input['type_id'] = $id;
            $input['key'] = $key;//.'-'.$model->id
            $input['type'] = 'vendor';
            $url = Urls::saveUrl($input);
            Session::flash('success', 'Your profile has been updated.');
            return redirect('vendor/view-profile');
        }
        
    }
    public function all_contacts()
    {
        $data = array();
        //total contact 
        $user_id = Auth::user()->id;
        $data['totalcontacts'] = User::where('role_id', '=', 3)->Where('vendor_id', '=', $user_id)->get();
        return view('vendors.contacts.view_all',$data);
    }
    public function commission() {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
            $permission = Permissions::getPermission($user_id,'commission');
            if($permission==0)
            {
                abort(403);
            }
        }
        $allCategories = Categories::orderby("id","asc")->get();
        $categories = Functions::getCategories($allCategories);
      
        return view('vendors.commission.index', compact('categories','allCategories'));
    }
    public function getCategories(Request $request) {
        if($request->ajax()) {
        $parent_id = $request->id;
        $category_id = $request->category_id;
        $subCategories = Categories::where('parent_id',"=",$parent_id)->orderby("name","asc")->get();
        $output = '';
        foreach($subCategories as $subCategory)
        { 
        $seperater ='';    
        $selected =''; 
        if($subCategory->level==2) {
            $seperater = ' <strong>></strong>';
        }    
            $selected = ($category_id==$subCategory->id)?'selected':'';
            $output .= '<option value="'.$subCategory->id.'" '.$selected.'>'. $subCategory->name .''. $seperater .'</option>';

        }
        echo $output;
        }
        
    }
   
     public function logout() {
       Auth::logout();
       return redirect('vendor/login');
    }

}
