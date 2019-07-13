<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\VendorController;
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
use DB,Auth;
use Illuminate\Support\Facades\Input as Input;
use Session;

class GalleryController extends VendorController {

    public function __construct() {
        parent::__construct();
    }

    public function addImage(Request $request) {
        $product_id = $request->id;

        return view('vendors.products.image', compact("product_id", "code"));
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
            $user_id = Auth::user()->id;
            $url = Urls::getUrl($user_id,'vendor');
            $folder = $url->key;
            $path = 'uploads/products/' . $folder;
            $destinationPath = public_path() . '/' . $path;
            $destinationPathLarge = $destinationPath . '/large/';
            $fileName = Functions::saveImage($file, $destinationPathLarge);
            $destinationPathThumb = $destinationPath . '/thumbnail/';
            $destinationPathMedium = $destinationPath . '/medium/';
            $extension = 'jpg';
            //Image::make($destinationPathLarge . $fileName)->resize('680','680')->save($destinationPathLarge . $fileName);
            Image::make($destinationPathLarge . $fileName)->encode($extension)->fit('500')->save($destinationPathLarge . $fileName,60);
            Image::make($destinationPathLarge . $fileName)->fit('200')->save($destinationPathThumb . $fileName,60);
            Image::make($destinationPathLarge . $fileName)->fit('400')->save($destinationPathMedium . $fileName,60);

            //list($width, $height) = getimagesize($destinationPathLarge . $fileName);
            $path = $path. '/large/';
            $model->product_id = $product_id;
            $model->image_name = $fileName;
            $model->path = 'uploads/products/' . $folder;
            $model->sort_order = $sort_order;
            $model->url = $path . $fileName;
            $model->save();
//            $model->width = $width;
//            $model->height = $height;
            
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

        return view('vendors.products.gallery', compact("product_id", "order", "gallery_images"));
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
        $this->deleteImages($image);
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
                $this->deleteImages($image);
                $image->delete();
            }
        }
        return redirect()->back()
                        ->with('success', 'All Images Deleted successfully.');
    }
    public function deleteImages($image) {
        $file = public_path() . '/' . $image->url;
        if (file_exists($file)) {
            @unlink($file);
        }
        $file = public_path() . '/' . $image->path . '/thumbnail/' . $image->image_name;
        if (file_exists($file)) {
            @unlink($file);
        }
        $file = public_path() . '/' . $image->path . '/medium/' . $image->image_name;
        if (file_exists($file)) {
            @unlink($file);
        }
    }
   
    

    
}
