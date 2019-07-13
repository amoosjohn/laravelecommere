<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {
	//
    protected $table='slider';
    
    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }
    public static $status=[""=>"Select Status","1"=>"Active","0"=>"Deactive"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red-thunderbird"];
    public static $types=[""=>"Select Type","1"=>"Slider","2"=>"Top Image","3"=>"Bottom Image","4"=>"Brand Side Image","5"=>"Category Banner Image"
        ,"6"=>"Category Slider"];
    
    
    
}
