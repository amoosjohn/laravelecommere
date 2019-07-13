<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model {
    protected $table='gallery_images';
    
    public static function getImages($user_id,$count=0,$limit=0){
        $result = GalleryImage::join('products as p','p.id','=','gallery_images.product_id')
                 ->select('gallery_images.*')   
                 ->where('gallery_images.download','=',0);
                if ($user_id != 0) {
            $result = $result->where('p.user_id', '=', $user_id);
        }
        $result = $result->orderBy('gallery_images.id', 'asc');
        if($count==1) {
            $result = $result->count();
        } 
        else {
            $result = $result->limit($limit)->get();
        }
                
        return $result;
    }
    public static function getMainImage($id){
        $image = asset('front/images/no-image.jpg');
        $getImage = GalleryImage::where("product_id", "=", $id)->where("sort_order", "=", 1)->first();
        if (count($getImage) > 0) {
            $imageName = public_path() . '/' . $getImage->path . '/thumbnail/' . $getImage->image_name;
            if (@file_exists($imageName)) {
                $image = asset('/' . $getImage->path . '/thumbnail/' . $getImage->image_name);
            } elseif(@file_exists(public_path() . '/' .$getImage->url)) {
                $image = asset('/' . $getImage->url);
            }
        }
        return $image;
    }
    public static function deleteAllImages($toDelete){
        if (count($toDelete)>0) {
        foreach($toDelete as $product_id) {
            $gallery_images = GalleryImage::where("product_id", "=", $product_id)->get();
            if (count($gallery_images)>0) {
                foreach ($gallery_images as $image) {
                    GalleryImage::deleteImages($image);
                }
            }
        }
        GalleryImage::whereIn('product_id',$toDelete)->delete();
        }
    }
    public static function deleteImages($image) {
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
