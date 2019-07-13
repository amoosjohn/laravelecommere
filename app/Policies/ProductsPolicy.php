<?php

namespace App\Policies;

use App\User;
use App\Permissions;
use App\UsersPermissions;
use Gate;
use Illuminate\Auth\Access\HandlesAuthorization;


class ProductsPolicy
{
    use HandlesAuthorization;
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function product_list(User $user)
    {
//        $permission = Permissions::getPermission($user->id, 'product_list');
//        if (count($permission) == 0) {
            //return $user->id == $user_id;
            return TRUE;
        //}
        //return $user->id == $permission->user_id;
    }
    public function product_create(User $user)
    {
        if($user->role_id==3)
        {
            return true;
        }
        $permission = Permissions::getPermission($user->id,'product_create');
        if(count($permission)>0)
        {
            return $user->id == $permission->user_id;
        }
    }
    public function product_update(User $user)
    {
        if($user->role_id==3)
        {
            return true;
        }
        $permission = Permissions::getPermission($user->id,'product_update');
        if(count($permission)>0)
        {
            return $user->id == $permission->user_id;
        }
    }
    public function product_delete(User $user)
    {
        $permission = Permissions::getPermission($user->id,'product_delete');
        if(count($permission)>0)
        {
            return $user->id == $permission->user_id;
        }
    }
    
    
}
