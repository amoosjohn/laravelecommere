<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cities extends Model {

    protected $table='cities';
    
    public static function regions()
    {
        $result = DB::table('regions')->orderby('name','asc')->pluck('name','id')
                ->prepend('Select Region*','')->all();
        return $result;
    }
    public static function getCities($region)
    {
        $result = Cities::where('region_id','=',$region)->orderby('name','asc')->get();
        return $result;
    }
}
