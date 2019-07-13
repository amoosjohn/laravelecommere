<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];
    protected $hidden = ['_token'];
    protected $table = 'payments';
    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }
    public static $status=[""=>"Select Status","1"=>"Active","0"=>"Deactive"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red-thunderbird"];
    public static $methods=[""=>"Select Type","1"=>"Cash","2"=>"Cheque","3"=>"Online Banking"];
    
    public static function search($search='') {
        $result = Payments::with("users");
        if(isset($search['user_id']) && $search['user_id']!='')
        {
            $result= $result->where("user_id","=",$search['user_id']);
        }
        if(isset($search['method']) && $search['method']!='')
        {
            $result= $result->where("method","=",$search['method']);
        }
        if(isset($search['date']) && $search['date']!='')
        {
            $result= $result->where("date","=",$search['date']);
        }
        
        $result = $result->orderby("id","desc")->paginate(15);
        
        return $result;
    }
    
    
}
