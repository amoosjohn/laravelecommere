<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
use App\Http\Requests;
use Validator,
    Input,
    Redirect,Config,DB,Auth,Session;
use App\Categories;
use App\Brands;
use App\Urls;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use App\Functions\Functions;
use App\Products;
use App\Colours;
use App\GalleryImage;
use App\User;
use App\Size;
use App\ProductSize;
use App\ProductVariations;
use App\UsersPermissions;
use App\Permissions;

class ExportController extends VendorController
{
    public function __construct() {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request) {
        if($request->ajax()) {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
        $permission = Permissions::getPermission($user_id,'product_export');
        if($permission==0)
        {
            abort(403);
        }
        }
        //Export
        $search['product_id'] = $request->input('product_id');
        $search['category_id'] = $request->input('category_id');
        $search['status'] = $request->input('status');
        $search['product_name'] = $request->input('product_name');
        $search['brand_id'] = $request->input('brand_id');
        $search['price_min'] = $request->input('price_min');
        $search['price_max'] = $request->input('price_max');
        $user_id = Auth::user()->id;
        $products = Products::search($search,$user_id,1);
        
        $tot_record_found=0;
        if (count($products) > 0) {
            $tot_record_found = 1;
            $statuses = Products::$status;
            $stock_status= Products::$stock_status;

            $CsvData = array('ID,Category name,Brand name,Colour name,Product Name,Status,Sku,Price,Sale price,Discount %,Commission,Cost Price,Material,Short description,Description,quantity,stock status,shipping,weight(KG),length,width,height,date available,delivery,warranty,tax class,meta title,meta keyword,meta description,created date');
            foreach ($products as $product) {
                $status = '';
                $stockStatus = '';
                $commission = 0;
                if (array_key_exists($product->status, $statuses)) {
                    $status = $statuses[$product->status];
                }
                if(isset($product->categoryCommission)) {
                    $price = ($product->sale_price == 0) ? $product->price : $product->sale_price;
                    $commission = Functions::calculateCommission($product->categoryCommission, $price);
                }
                if (array_key_exists($product->stock_status, $stock_status)) {
                    $stockStatus = $stock_status[$product->stock_status];
                }
                $shipping = ($product->shipping==1)?'Yes':'No';
                $weight = ($product->weight!='')?$product->weight:'';
                $short_description=Functions::addBrTag(str_replace(","," ",$product->short_description));
                $description=Functions::addBrTag(str_replace(","," ",$product->description));
                $categoryName=Functions::addBrTag(str_replace(","," ",$product->categoryName));
                $brandName=Functions::addBrTag(str_replace(","," ",(count($product->brands)>0)?$product->brands->name:''));
                $colourName=Functions::addBrTag(str_replace(","," ",(count($product->colours)>0)?$product->colours->name:''));
                $name=Functions::addBrTag(str_replace(","," ",$product->name));
                
                $CsvData[] = $product->id . ',' . $categoryName. ',' . 
                             $brandName . ',' . $colourName. ','.
                             $name . ',' . $status. ','.
                             $product->sku . ',' . $product->price. ','.
                             $product->sale_price . ',' . $product->discount. ','.
                             str_replace(",","",$commission) . ',' . $product->costPrice . ',' . $product->material. ','.
                             $short_description. ','.
                             $description . ',' . $product->quantity. ','.
                             $stockStatus . ',' . $shipping. ','.
                             $weight . ',' . $product->length. ','.
                             $product->width . ',' . $product->height. ','.
                             date('d/m/Y', strtotime($product->date_available)) . ',' . $product->delivery. ','.
                             $product->warranty . ',' . $product->tax_class. ','.
                             stripslashes($product->meta_title) . ',' . stripslashes($product->meta_keyword). ','.
                             stripslashes($product->meta_description) . ',' . date('d/m/Y', strtotime($product->created_at));
            }
            
            
            $filename = date('Y-m-d_H:i:s')."_products.csv";
            $file_path =  public_path() .'/uploads/products/csv/' . $filename;
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
    }
    public function exportCategory(Request $request) {
        if($request->ajax()) {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
        $permission = Permissions::getPermission($user_id,'product_export');
        if($permission==0)
        {
            abort(403);
        }
        }
        $categories = Categories::leftJoin("categories as subcat","subcat.id","=","categories.parent_id")
                ->leftJoin("categories as parentcat","parentcat.id","=","subcat.parent_id")
                ->select("categories.*","subcat.name as categoryName","parentcat.name as parentName") 
                ->where("categories.level",3)
                ->orderby("id","asc")->get();
        
        if (count($categories) > 0) {
            $statuses = Products::$status;
            $stock_status= Products::$stock_status;

            $CsvData = array('Main Category,Sub Category,Child Category');
            foreach ($categories as $item) {
                $CsvData[] = $item->parentName . ',' . $item->categoryName. ',' . 
                             $item->name;
            }
            $filename = date('Y-m-d_H:i:s')."_categories.csv";
            $file_path =  public_path() .'/uploads/products/csv/' . $filename;
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
        
    }
    public function delete(Request $request) {
        if($request->ajax()) {
        if(isset($request->delete)) {
            $user_id = Auth::user()->id;
            if(Auth::user()->role_id==4){
                $permission = Permissions::getPermission($user_id,'product_export');
                if($permission==0)
                {
                    abort(403);
                }
            }
            $file = public_path() . '/uploads/products/csv/'.$request->file;
            if (file_exists($file)) {
               @unlink($file);
            }
            echo 1;
            exit();
            }
        }
    }
}
?>