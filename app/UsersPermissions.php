<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model
{
    //
    public function children()
    {
        return $this->hasMany('App\Permissions', 'parent_id', 'id');
    }
}
