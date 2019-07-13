<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Validator,
    Redirect;
use App\User;
use App\Properties;
use App\Gallery;
use App\GalleryImage;
use App\Urls;
use App\Functions\Functions;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use DB;
use Illuminate\Support\Facades\Input as Input;
use Session;
use App\Products;

class GalleryController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function addImage(Request $request) {
        $product_id = $request->id;

        return view('admin.products.image', compact("product_id", "code"));
    }

    public function uploadImage(Request $request) {

        $product_id = $request->product_id;

        $rules['image'] = 'required|dimensions:min_width=500,min_height=500|mimes:jpeg,bmp,png,jpg,jpeg|max:2000';

        $message = [
            'image.max' => 'Image size must be less or equal to 2MB.',
            'image.dimensions' => 'Image must be upload with minimum 500x500 demension'
        ];

        $response['error'] = 0;

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
            //return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $orders = GalleryImage::where("product_id", "=", $product_id)->orderby("sort_order", "desc")->get();
            $sort_order = (count($orders) > 0) ? $orders[0]->sort_order + 1 : 1;

            $model = new GalleryImage;
            $file = Input::file('image');
            $size = Input::file('image')->getSize();
            $getProduct = Products::find($product_id);
            $user_id = $getProduct->user_id;
            $url = Urls::getUrl($user_id,'vendor');
            $folder = $url->key;
            $path = 'uploads/products/' . $folder;
            $destinationPath = public_path() . '/' . $path;
            $destinationPathLarge = $destinationPath . '/large/';
            $fileName = Functions::saveImage($file, $destinationPathLarge);
            chmod($destinationPathLarge . $fileName, config('lfm.create_file_mode', 0777));
            $destinationPathThumb = $destinationPath . '/thumbnail/';
            $destinationPathMedium = $destinationPath . '/medium/';
            //Image::make($destinationPathLarge . $fileName)->resize('680','680')->save($destinationPathLarge . $fileName);
            Image::make($destinationPathLarge . $fileName)->resize('500','500')->save($destinationPathLarge . $fileName);
            Image::make($destinationPathLarge . $fileName)->resize('200','200')->save($destinationPathThumb . $fileName);
            Image::make($destinationPathLarge . $fileName)->resize('400','400')->save($destinationPathMedium . $fileName);            chmod($destinationPathThumb . $fileName, config('lfm.create_file_mode', 0777));
            chmod($destinationPathMedium . $fileName, config('lfm.create_file_mode', 0777));
            $path = $path. '/large/';
            $model->product_id = $product_id;
            $model->image_name = $fileName;
            $model->path = 'uploads/products/' . $folder;
            $model->sort_order = $sort_order;
            $model->url = $path . $fileName;
            $model->save();

            //Session::flash('pageclose', '0');
            //return redirect('admin/property/addimage/'.$product_id)->with('success','Image Uploaded successfully.');
            $response['error'] = 0;
        }
        if ($response['error'] == 1) {
            foreach ($response['errors']->all() as $error) {
                echo '<li>' . $error . '</li>';
            }
        } else {
            echo '0';
        }
    }

    public function addMultipleImage(Request $request) {
        $product_id = $request->id;
       

        return view('admin.products.multipleimage', compact("product_id"));
    }

    public function uploadMultipleImage(Request $request) {
        $product_id = $request->product_id;
        $images = Input::file('images');
        if (Input::hasFile('images')) {
            $image_count = count($images);
            $response['error'] = 0;
            $orders = GalleryImage::where("product_id", "=", $product_id)->orderby("sort_order", "desc")->get();
            $sort_order = (count($orders) > 0) ? $orders[0]->sort_order + 1 : 1;
            $uploadcount = 0;
            foreach ($images as $image) {

                $rules = array('images' => 'required|mimes:jpeg,bmp,png,jpg,jpeg|max:2000');
                $message = [
                    'images.max' => 'File size must be less or equal to 2MB.'
                ];
                $validator = Validator::make(array('images' => $image), $rules, $message);
                if ($validator->passes()) {
                    $model = new GalleryImage;
                    $file = $image;
                    $size = $image->getSize();
                    $path = 'uploads/products/';
                  
                    $destinationPath = public_path() . '/' . $path;
                    $destinationPathThumb = $destinationPath . 'thumbnail/';

                    if ($request->code != "") {
                        $fileName = Functions::saveImage($file, $destinationPath);
                    } else {
                        $fileName = Functions::saveImage($file, $destinationPath, $destinationPathThumb);
                        $upload = Image::make($destinationPath . $fileName)->fit(280)->save($destinationPathThumb . $fileName);
                    }

                    $ext = pathinfo(public_path() . '/' . $path . $fileName, PATHINFO_EXTENSION);

                    list($width, $height) = getimagesize($destinationPath . $fileName);

                    $model->product_id = $product_id;
                    $model->image_name = $fileName;
                    $model->file_size = $size;
                    $model->width = $width;
                    $model->height = $height;
                    $model->sort_order = $sort_order;
                    $model->url = $path . $fileName;
                    $model->save();
                    $uploadcount ++;
                    $sort_order++;
                } elseif ($validator->fails()) {

                    $errors = $validator->errors();
                    $response['error'] = 1;
                    $response['errors'] = $errors;
                }
            }
            if ($uploadcount == $image_count) {
                //\Session::flash('pageclose', '0');
                //return redirect('admin/property/addmultiple/'.$product_id)->with('success','Image Uploaded successfully.');;

                echo '0';
            } else {

                if ($response['error'] == 1) {
                    foreach ($response['errors']->all() as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                }

                //return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }
    }

    public function loadGallery(Request $request) {

        $product_id = $request->product_id;
       
        $gallery_images = GalleryImage::where("product_id", "=", $product_id)->orderby("sort_order", "asc")->get();
        $order = array();
        if ($gallery_images->count()) {

            $image = 1;
            foreach ($gallery_images as $total_image) {
                $order[$image] = $image;
                $image++;
            }
        }

        return view('admin.products.gallery', compact("product_id", "order", "gallery_images"));
    }

    public function deleteImage($id) {
        $image = GalleryImage::findOrFail($id);
        $product_id = $image->product_id;
        $replace_order = $image->sort_order;

        $count = GalleryImage::where("product_id", "=", $product_id)
                        ->where("id", "!=", $id)->orderby("sort_order", "asc")->get();

        for ($i = $replace_order; $i <= count($count); $i++) {
            if ($replace_order == $i) {
                $update_order = $replace_order;
            } else {
                $update_order = $i;
            }

            $gallery_image = GalleryImage::where("product_id", "=", $product_id)
                    ->where("id", $count[$i - 1]->id)
                    ->update(array('sort_order' => $update_order));
        }

        $file = public_path() . '/' . $image->url;
        if (file_exists($file)) {
            unlink($file);
        }
        $image->delete();



        return redirect()->back()
                        ->with('success', 'Image Deleted successfully.');
    }

    public function deleteAllImage(Request $request) {
        $product_id = $request->product_id;
       
        $gallery_images = GalleryImage::where("product_id", "=", $product_id)->get();
        if (count($gallery_images)>0) {
            foreach ($gallery_images as $image) {
                $image = GalleryImage::findOrFail($image->id);
                $file = public_path() . '/' . $image->url;
                if (@file_exists($file)) {
                    @unlink($file);
                }
                $image->delete();
            }
        }
        return redirect()->back()
                        ->with('success', 'All Images Deleted successfully.');
    }

    public function insertOrder(Request $request) {
      
        $product_id = $request->product_id;
        if (count($request->ids) > 0) {

            $images = explode(",",$request->ids);
            $count = 1;
            foreach ($images as $id){
                $gallery_image = GalleryImage::where("product_id", "=", $product_id)
                        ->where("id", "=", $id)
                        ->update(array('sort_order' => $count));
                $count ++;	
            }
            echo "1";
        }
    }

    public function updateGallery($product_id) {
        $gallery_images = GalleryImage::where("product_id", "=", $product_id)
                        ->orderby("sort_order", "desc")->get();
        if ($gallery_images->count()) {

            $order = 1;
            //$count = 0;
            foreach ($gallery_images as $image) {
                $gallery_image = GalleryImage::where("id", "=", $image->id)
                        ->update(array('sort_order' => $order));

                //$count++;
                $order++;
            }


            echo 'success';
            die;
        }
        echo 'error';
        die;
    }

}
