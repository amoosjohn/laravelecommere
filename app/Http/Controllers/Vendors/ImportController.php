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
use App\OrderProducts;

class ImportController extends VendorController
{
    public function __construct() {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request) {
        $user_id = Auth::user()->id;
        if(Auth::user()->role_id==4){
            $permission = Permissions::getPermission($user_id,'product_import');
            if($permission==0)
            {
                abort(403);
            }
        }
        $remainingImages = GalleryImage::getImages($user_id,1);//::where('download','=',0)->orderBy('id','asc')->count();
        return view('vendors.products.import',compact('remainingImages'));

    }
    public function upload(Request $request) {

        try {
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        $type = $request->type;
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                //open uploaded csv file with read only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                
                fgetcsv($csvFile);
                if ($type == 'product') {
                  while (($line = fgetcsv($csvFile)) !== FALSE) {
                      
                    if($line[1]!='') {
                    $sizeSku = $line[7];
                    $sizes = $line[8];
                    $quantity = $line[14];
                    $productName = $line[4];
                    $user_id = Auth::user()->id;
                    $product = Products::where('name', '=', $productName)->first();
                    //dd($product);
                   if(count($product)==0) {
                    $category = Categories::where('name', '=', $line[1])->first();
                    if(count($category)>0) {
                        $category_id = $category->id;
                    }
                    else {
                        $category_id = 1;
                    }      
                    $brand = Brands::where('name', '=', $line[2])->first();
                    if(count($brand)>0) {
                        $brand_id = $brand->id;
                    }
                    else {
//                          $model = new Brands;
//                          $model->name = $line[2];
//                          $model->user_id = $user_id;
//                          $model->status = 1;
//                          $model->save();
//                          $key = Functions::slugify($line[2]);
//                          $input = array();
//                          $input['type_id'] = $model->id;
//                          $input['key'] = $key . '-' . $model->id;
//                          $input['type'] = 'brand';
//                          $url = Urls::saveUrl($input);
                          $brand_id = '';
                      }

                   $colour= Colours::where('name', '=', $line[3])->first();
                    if(count($colour)>0) {
                        $colour_id = $colour->id;
                    }
                    else {
//                          $model = new Colours;
//                          $model->name = $line[3];
//                          $model->user_id = $user_id;
//                          $model->status = 1;
//                          $model->save();
                          $colour_id = '';
                      }
                    $model = new Products;
                    $model->user_id = $user_id; //$line[1]
                    $model->category_id = $category_id; //$line[2]
                    $model->brand_id = $brand_id;
                    $model->colour_id = $colour_id;
                    $model->name = $line[4];
                    $model->status = ($line[5]=='Enable')?1:0;
                    $model->sku = $line[6];//$line[7]
                    $model->price = $line[9];
                    $model->sale_price = $line[10];
                    $model->discount = $line[11];
                    $model->short_description = $line[12];
                    $model->description = $line[13];//return $line[13]
                    $model->quantity = $line[14];
                    $model->stock_status = 1; //:0
                    $model->shipping = ($line[16]=='Yes')?1:0;
                    $model->weight = $line[17];
                    $model->length = $line[18];
                    $model->width = $line[19];
                    $model->height = $line[20];
                    $model->date_available = date('d/m/Y',strtotime($line[21]));
                    $model->delivery = $line[22];
                    $model->warranty = $line[23];
                    $model->tax_class = $line[24];
                    $model->meta_title = $line[25];
                    $model->meta_keyword = $line[26];
                    $model->meta_description = $line[27];
                    $model->material = $line[28];
                    $model->save();
                    $product_id = $model->id;
                    $key = Functions::slugify($line[4]);
                    $random = Functions::generateRandomString(6,1);

                    $input = array();
                    $input['type_id'] = $product_id;
                    $input['key'] = $key.'-'.$random;
                    $input['type'] = 'product';
                    $url = Urls::saveUrl($input);
                    
                    $url = Urls::getUrl($user_id,'vendor');
                    $path = 'uploads/products/'.$url->key.'/';
                    for($i=29;$i<=36;$i++){
                        $fileName = $line[$i];
                        if($fileName!='') {
                            $orders = GalleryImage::where("product_id", "=", $product_id)->orderby("sort_order", "desc")->get();
                            $sort_order = (count($orders) > 0) ? $orders[0]->sort_order + 1 : 1;
                            $model = new GalleryImage;
                            $model->product_id = $product_id;
                            $model->path = $path;
                            $model->sort_order = $sort_order;
                            if(stripos($fileName,"https://")!==FALSE || stripos($fileName,"http://")!==FALSE)
                            {
                                $model->download = 0;
                                $model->url = $fileName;
                            }
                            else {
                                $model->image_name = $fileName;
                                $model->url = $path . $fileName;
                            }
                            $model->save();
                            
                        }
                    }
                    if($sizes!='') {
                        $size = Size::where('name','=',$sizes)->first();
                        if (count($size) > 0) {
                            $size_id = $size->id;
                            $data = array();
                            $data[] = array('product_id' => $product_id, 'size_id' => $size_id,
                                            'quantity' => $quantity,'sku' => $sizeSku,
                                            'created_at' => date('Y-m-d H:i:s'));
                            if (count($data) > 0) {

                                ProductSize::insert($data);
                            }
                       }
                    }
                    
                    }  
                    if(count($product)>0 && $sizes!='') {
                        
                        if($productName==$product->name)
                        {
                            $size = Size::where('name', '=', $sizes)->first();
                            if(count($size) > 0) {
                                $size_id = $size->id;
                                $data = array();
                                $data[] = array('product_id' => $product_id, 'size_id' => $size_id,
                                            'quantity' => $quantity,'sku' => $sizeSku,
                                            'created_at' => date('Y-m-d H:i:s'));
                                if (count($data) > 0) {
                                    ProductSize::insert($data);
                                }
                            }
                        }

                       
                    }
                    
                   }
                  }
                }
                
                //close opened csv file
                fclose($csvFile);

                $qstring = 'succ';
            } else {
                $qstring = 'err';
            }
        } else {
            $qstring = 'invalid_file';
        }

        return redirect()->back()->with('status',$qstring);
        }
        catch (Exception $ex){
            
            return redirect()->back()->with('danger','Error in import sheet!');
        }
    }
    
    public function importImages(Request $request) {
       //Note 100 Images be will downloaded from url request 
       try {
       $user_id = Auth::user()->id; 
       $limit = 100; 
       $images = GalleryImage::getImages($user_id,0,$limit);
       $imageMimes = Config::get('params.imageMimes');
       $extension = 'jpg';
        if(count($images)>0) {
        foreach($images as $image) {
            $url = $image->url;
            $path = $image->path;
            if($url!='' && $path!='' && @getimagesize($url) ) {
             $move = Image::make($url)->mime();
             if(in_array($move,$imageMimes)) {  
                 $fileName = rand(111, 999) . time() . '.' . $extension; 
                 $destinationPath = public_path() . '/' . $path;
                 $destinationPathLarge = $destinationPath . '/large/';
                 $destinationPathThumb = $destinationPath . '/thumbnail/';
                 $destinationPathMedium = $destinationPath . '/medium/';
                 Image::make($url)->encode($extension)->save($destinationPathLarge . $fileName); 
                 Image::make($destinationPathLarge . $fileName)->resize('500','500')->save($destinationPathLarge . $fileName,60);
                 Image::make($destinationPathLarge . $fileName)->resize('200','200')->save($destinationPathThumb . $fileName,60);
                 Image::make($destinationPathLarge . $fileName)->resize('400','400')->save($destinationPathMedium . $fileName,60);

                 $path = $path. 'large/';
                 $input['download'] = 1;
                 $input['url'] = $path.$fileName;
                 $input['image_name'] = $fileName;
                 GalleryImage::where('id','=',$image->id)->update($input);
             }
            }
            else {
                GalleryImage::where('id','=',$image->id)->delete();
            }
         }
         return redirect('vendor/product/import')->with('success','All Images Downloaded Successfully!');
       }
       else {
           return redirect('vendor/product/import')->with('danger','No image found to be download!');
       }
       }
       catch (Exception $ex) {
           return redirect('vendor/product/import')->with('danger','some images are interrupting!');
       }
    }
    public function importPrices(Request $request) {
      $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        $type = $request->type;
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                //open uploaded csv file with read only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                
                fgetcsv($csvFile);
                if ($type == 'price') {
                    $user_id = Auth::user()->id;
                    if (Auth::user()->role_id == 4) {
                        $user_id = Auth::user()->vendor_id;
                    }
                    while (($line = fgetcsv($csvFile)) !== FALSE) {
                      $id = $line[0];
                      $price = $line[1];
                      if($id!='' && $id!=0 && $price!='' && $price!=0) {
                          $search['product_id'] = $id;
                          $products = Products::search($search,$user_id);
                          if(count($products)>0) {
                            $salePrice = ($line[2] != 0 && $line[2] != '') ? $line[2] : $price;
                            $input['price'] = $price;
                            $input['sale_price'] = $salePrice;
                            $input['discount'] = $line[3];
                            $product =  $products[0]; 
                            $commission = 0;
                            if (isset($product->categoryCommission)) {
                                  $commission = Functions::calculateCommission($product->categoryCommission, $salePrice);
                            }
                            $costPrice = $salePrice - $commission;
                            $input['costPrice'] = $costPrice;
                            Products::where('id','=',$id)->update($input);
                          }
                      }
                  }
                }
                
                //close opened csv file
                fclose($csvFile);

                $qstring = 'succ';
            } else {
                $qstring = 'err';
            }
        } else {
            $qstring = 'invalid_file';
        }

        return redirect('vendor/product/import')->with('status',$qstring);  
    }
    
}
?>