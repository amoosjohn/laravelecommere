<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'size';
    
    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }
    public static $status=[""=>"Select Status","1"=>"Active","0"=>"Deactive"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red-thunderbird"];


}
