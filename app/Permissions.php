<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //
    public function children()
    {
        return $this->hasMany('App\Permissions', 'parent_id', 'id');
    }
    public static function getPermission($id,$code) {
        $result = Permissions::where('permissions.name', '=', $code)
                ->join('users_permissions as up','up.permission_id','=','permissions.id')
                ->select('up.user_id')
                ->where('up.user_id', $id)
                ->count();
        return $result;
    }
}
