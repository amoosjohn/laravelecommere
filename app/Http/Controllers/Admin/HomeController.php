<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use App\Urls;
use Validator,
    Input,
    Redirect,Hash;
use Session,Config;
use App\Categories;
use App\Products;
use App\Brands;
use App\Colours;
use App\Functions\Functions;
use Auth;
use Illuminate\Http\Request;
use App\NewsLetter;
use App\Orders;

class HomeController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();

        $data['totalUsers'] = User::where('role_id', '=', 3)->count();
        $data['totalCategories'] = Categories::count();
        $countProducts = Products::search('','',1);
        $data['totalProducts'] = Products::count();//$countProducts->count();
        //$data['totalProducts'] = Products::with("users")->count();
        $data['totalOrders'] = Orders::with("users")->count();
        $data['totalPendingOrders'] = Orders::with("users")->where("status","!=",5)->count();
        $data['totalCustomers'] = User::where('role_id', '=', 6)->count();
        $result = Orders::totalAmount('',date('Y'));
        $data['totalSales'] = (count($result['sales'])>0)?$result['sales']:0;
        $data['totalPending'] = (count($result['pending'])>0)?$result['pending']:0;
        $sales = Orders::getSalesByMonth();
        $chartData = '';
        if(count($sales)>0) {
            $count = 1;
            for($i=0;$i<12;$i++) {  
                $year = isset($sales[$i]['year'])?$sales[$i]['year']:$year;
                $month = isset($sales[$i]['month'])?$sales[$i]['month']:$count;
                $total = isset($sales[$i]['total'])?$sales[$i]['total']:0;

                $chartData .= "{ year:'".$year.'-'.$month."',total:".$total."}, ";
                $count++;
            }
            $chartData = substr($chartData, 0, -2);
        }
        $orders = Orders::getOrdersByMonth();
        //dd($orders);
        $chartData2 = '';
        if(count($orders)>0) {
            $count = 1;
            for($i=0;$i<12;$i++) {  
                $year = isset($orders[$i]['year'])?$orders[$i]['year']:$year;
                $month = isset($orders[$i]['month'])?$orders[$i]['month']:$count;
                $total = isset($orders[$i]['count'])?$orders[$i]['count']:0;

                $chartData2 .= "{ year:'".$year.'-'.$month."',total:".$total."}, ";
                $count++;
            }
            $chartData2 = substr($chartData2, 0, -2);  
            $total = 0;
        }
        $currency = Config::get("params.currencies");
        $symbol = $currency["PKR"]["symbol"];
        $year = date("Y");
        return view('admin.index',$data)->with("chartData",$chartData)
                ->with("year",$year)->with("symbol",$symbol)
                ->with("chartData2",$chartData2);
    }
    public function logout() {
       Auth::logout();
       return redirect('admin/login');
    }
    
    public function import(Request $request) {

        return view('admin.upload', compact("model"));
    }
    public function upload(Request $request) {

        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        $type = $request->type;
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                

                //open uploaded csv file with read only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                //$line = fgetcsv($csvFile);
               // dd($line);
               
                //skip first line
                fgetcsv($csvFile);
               
               // dd(fgetcsv($csvFile));
                if ($type == 'area') {   
                    while (($line = fgetcsv($csvFile)) !== FALSE) {
                        
                        $i=1;
                        $parent_id=0;
                        foreach($line as $row){
                            
                            if($row==""){
                                $parent_id=0;
                                break;
                            }
                            
                            $category=Categories::where('name', '=',$row)->where('parent_id',$parent_id)->first();
                            
                            if($category==null){
                                $model = new Categories;
                                $model->name = $row;
                                if($i==1){
                                    $model->parent_id = 0;
                                }else{
                                    $model->parent_id = $parent_id;
                                }
                                
                                $model->level = $i;
                                $model->save();
                                $parent_id =  $model->id;
                                
                                $key = Functions::slugify($row."-".$model->id);
                                $input = array();
                                $input['type_id'] = $model->id;
                                $input['key'] = $key;//.'-'.$model->id
                                $input['type'] = 'category';
                                $url = Urls::saveUrl($input);
                                
                                
                            }else{
                                $parent_id=$category->id;
                            }
                            $i++;
                            
                            if($i==4){
                                break;
                            }
                            
                            
                        } //end foreach
                        
                        continue;
                        // dd($line[0]);
                         
                        
                        
                    } //end while
                  
                    //die;
                }
                if ($type == 'product') {
                  while (($line = fgetcsv($csvFile)) !== FALSE) {
                     
                      /*$vendor = User::where('firstName', '=', $line[1])
                                ->where('role_id', '=',3)->first();
                      if(count($vendor)>0) {
                          $user_id = $vendor->id;
                      }
                      else {
                          
                      }*/
                      if($line[0]!='') {
                      $product = Products::where('name', '!=', $line[5])->get();
                      if(count($product)>0) {
                      $brand = Brands::where('name', '=', $line[3])->first();
                      if(count($brand)>0) {
                          $brand_id = $brand->id;
                      }
                      else {
                            $model = new Brands;
                            $model->name = $line[3];
                            $model->user_id = Auth::user()->id;
                            $model->status = 1;
                            $model->save();
                            $key = Functions::slugify($line[3]);
                            $input = array();
                            $input['type_id'] = $model->id;
                            $input['key'] = $key . '-' . $model->id;
                            $input['type'] = 'brand';
                            $url = Urls::saveUrl($input);
                            $brand_id = $model->id;
                        }
                        
                     $colour= Colours::where('name', '=', $line[4])->first();
                      if(count($colour)>0) {
                          $colour_id = $colour->id;
                      }
                      else {
                            $model = new Colours;
                            $model->name = $line[4];
                            $model->user_id = Auth::user()->id;
                            $model->status = 1;
                            $model->save();
                            $colour_id = $model->id;
                        }
                        
                    $model = new Products;
                    $model->user_id = 27; //$line[1]
                    $model->category_id = 1; //$line[2]
                    $model->brand_id = $brand_id;
                    $model->colour_id = $colour_id;
                    $model->name = $line[5];
                    $model->status = ($line[6]=='Enable')?1:0;
                    $model->sku = '123456';//$line[7]
                    $model->price = $line[8];
                    $model->sale_price = $line[9];
                    $model->discount = $line[10];
                    $model->short_description = $line[11];
                    $model->description = $line[12];//return $line[13]
                    $model->quantity = $line[14];
                    $model->stock_status = ($line[15]=='Instock')?1:0;
                    $model->date_available = date('d-m-Y',strtotime($line[26]));
                    $model->weight = 1;
                    $model->delivery = "1-5";
                    /*$model->shipping = $request->shipping;
                    $model->length = $request->length;
                    $model->width = $request->width;
                    $model->height = $request->height;
                    $model->meta_title = $request->meta_title;
                    $model->meta_keyword = $request->meta_keywords;
                    $model->meta_description = $request->meta_description;
                    $model->return_policy = $request->return_policy;*/
                    $model->save();
                    $product_id = $model->id;
                    $key = Functions::slugify($line[5]);
                    $random = Functions::generateRandomString(6,1);

                    $input = array();
                    $input['type_id'] = $product_id;
                    $input['key'] = $key.'-'.$random;
                    $input['type'] = 'product';
                    $url = Urls::saveUrl($input);
                    
                    
                    }  
                   }
                  }
                }
                

                
                //close opened csv file
                fclose($csvFile);

                $qstring = '?status=succ';
            } else {
                $qstring = '?status=err';
            }
        } else {
            $qstring = '?status=invalid_file';
        }

        return redirect('admin/import' . $qstring);
    }
 
    public function newsletter()
    {
        $news = NewsLetter::orderBy("id","desc")->paginate(15);
        return view('admin.news_letter', compact("news"));
    }
    public function delete($id)
    {
        NewsLetter::where("id","=",$id)->delete();
        return redirect('admin/newsletter')->with("success","Email Deleted Successfully!");
    }
    public function export(Request $request) {
        
        $news = NewsLetter::orderBy("id","desc")->get();
        if (count($news) > 0) {
            $CsvData = array('Email');

            foreach ($news as $new) {
                $CsvData[] = $new->email.",";
            }
            
            $filename = date('Y-m-d_H:i:s')."_newsletter.csv";
            $file_path =  public_path() .'/uploads/newsletter/' . $filename;
            $file = fopen($file_path, "w+");
            foreach ($CsvData as $exp_data) {
               $data = fputcsv($file, explode(',', $exp_data));
               
            }
            rewind($file);
            fclose($file);
            $headers = ['Content-Type' => 'application/csv'];
            return $filename;
            exit();
        }
        
    }
    public function changePassword()
    {
        $user_id = Auth::user()->id;
        $model = User::find($user_id);
        return view('admin.profile', compact("model"));
    }
    public function updatePassword(Request $request) {
        //
        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {

            return Hash::check($value, Auth::user()->password);
        });
        $validation = array(
            'old_password' => 'required|old_password',
            'password' => 'required|confirmed|min:6',
        );
        $message['old_password.old_password'] = 'The specified password does not match the database password';
        $validator = Validator::make($request->all(), $validation,$message);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        else
        {   
            $user_id = Auth::user()->id;
            $model = User::find($user_id);
            $input['password'] =  bcrypt($request->password);
            User::where('id', '=', $model->id)->update($input);
           
            \Session::flash('success', 'Password Changed Successfully!');
            return redirect('admin/password');
        }
    }
    
}
