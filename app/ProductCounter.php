<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCounter extends Model {

    protected $table = 'product_counter';
    public static function addCounter($ip,$id) {
        $productCounter = ProductCounter::where("product_id", "=", $id)
                        ->where("ip", "=", $ip)->first();
        if (count($productCounter) == 0) {
            $input['ip'] = $ip;
            $input['product_id'] = $id;
            $input['counter'] = 1;
            $input['created_at'] = date("Y-m-d H:i:s");
            ProductCounter::insert($input);
        }
    }

}
