<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

    protected $table = 'gallery';
    protected $fillable = [
        'title','image',
        
    ];

    public static function searchGallery($search) {
        $result = self::where("gallery.deleted", '=', 0);

        if (isset($search['title']) && $search['title'] != "") {
            $title = $search['title'];
            $result = $result->where('title', 'LIKE', "%" . $title . "%");
        }
//        if (isset($search['category_id']) && $search['category_id'] != "") {
//            $category_id = $search['category_id'];
//            $result = $result->where('category_id', '=', $category_id);
//        }

//        $result = $result->leftjoin('categories as c', 'c.id', '=', 'videos.category_id')
//                ->select('videos.*', 'c.id as category_id', 'c.name as category_name');

        // d($result,1);
        $result = $result->orderBy('id', 'desc');
        $result = $result->paginate(10);
        $result->setPath('gallery');
        return $result;
   }
    
   

}
