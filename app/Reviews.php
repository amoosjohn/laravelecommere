<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Functions\Functions;
use DB;

class Reviews extends Model {

    protected $table='reviews';
    
    public function users() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function products() {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }
    public static function getReviews($id){
       $result = Reviews::where("product_id","=",$id)->where("status","=",1)
                ->orderBy("id","desc")->limit(15)->get();
       return $result;
    }
    public static function getRatings($id){
       $result = Reviews::where("product_id","=",$id)->where("status","=",1)
                ->selectRaw("SUM(ratings) as ratingSum")
                ->selectRaw("COUNT(ratings) as ratingCount")->first();
       return $result;
    }
    
    public static function search($search='',$user_id){
       $result = Reviews::with("users")
               ->join("products as pro","pro.id","=","reviews.product_id")
               ->leftJoin("urls as u","pro.id","=","u.type_id")
               ->select("pro.name as productName","reviews.*","u.key as link");
        if($user_id!='')
        {
            $result= $result->where("pro.user_id","=",$user_id);
        }
            $result= $result->where('u.type', '=', 'product')
                ->orderBy("reviews.id", "desc")
               ->groupBy("reviews.id")
               ->paginate(10);
       return $result;
    }
    public static function getTotalRatings($id) {
        
        $ratings = Reviews::getRatings($id);
        $result['ratingCount'] = 0;
        $result['ratingSum'] = 0;
        $result['avgRating'] = 0;
        if (count($ratings) > 0) {
            if ($ratings->ratingCount != 0 && $ratings->ratingSum != 0) {
                $result['ratingCount'] = $ratings->ratingCount;
                $result['ratingSum'] = $ratings->ratingSum;
                $result['avgRating'] = Functions::avg($result['ratingSum'], $result['ratingCount']);
            }
        }
        return $result;
    }
    
}
