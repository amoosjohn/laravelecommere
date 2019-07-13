<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
	//
    protected $table='address';
    
    public function regions() {
        return $this->hasOne('App\Regions', 'id', 'region');
    }
    public function cities() {
        return $this->hasOne('App\Cities', 'id', 'city');
    }
    
    public static function getAddress($user_id,$type,$order_id=''){
        $result = Address::with('regions')->with('cities')->where('user_id','=',$user_id)
                   ->where('type','=',$type)->first();
        return $result;
    }
}
