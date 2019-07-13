<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urls extends Model {

    //
    protected $table = 'urls';

    public static function saveUrl($input) {
        //d($input,1);
        $id = $input['type_id'];
        $type = $input['type'];

        if (Urls::where('type', '=', $type)->where('type_id', '=', $id)->exists()) {
            $urls = Urls::where('type_id', $id)->where('type', '=', $type)->first();

            if ($urls->key != $input['key']) {
                Urls::where('id', $urls->id)->update(['key' => $input['key']]);
            }
        } else {
            $url = new Urls;
            $url->type = $input['type'];
            $url->type_id = $input['type_id'];
            $url->key = $input['key'];
            $url->save();
            return $url->id;
        }
    }

    public static function deleteUrl($type, $id,$toDelete='') {
        if($id!=0) {
            Urls::where('type', '=', $type)->where('type_id', '=', $id)->delete();
        }
        else {
            Urls::where('type', '=', $type)->whereIn('type_id',$toDelete)->delete();
        }
        
    }
    public static function getUrl($id,$type) {
        $result = Urls::where('type', '=', $type)->where('type_id', $id)->first();
        return $result;
    }

}
