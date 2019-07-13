<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes,Notifiable;
    protected $dates = ['deleted_at'];
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    public static $status=[""=>"Select Status","1"=>"Active","2"=>"Deactivate","0"=>"Pending"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red"];

    /**
     * Get the phone record associated with the user.
     */
    public function role() {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
    public function cities() {
        return $this->hasOne('App\Cities', 'id', 'city');
    }
    public function regions() {
        return $this->hasOne('App\Regions', 'id', 'region');
    }
    public function bankaccount() {
        return $this->hasOne('App\BankAccount', 'user_id', 'id');
    }
    public static function searchUser($search='',$role_id='') {

        if($role_id==''){
            $role_id = 2;
        }
        $result = User::where('role_id','=',$role_id);

        if (isset($search['firstName']) && $search['firstName'] != "") {
            $firstName = $search['firstName'];
            $result = $result->where('firstName', 'LIKE', "%" . $firstName . "%");
        }

        if (isset($search['lastName']) && $search['lastName'] != "") {
            $lastName = $search['lastName'];
            $result = $result->where('lastName', 'LIKE', "%" . $lastName . "%");
        }
        if (isset($search['email']) && $search['email'] != "") {
            $email = $search['email'];
            $result = $result->where('email', 'LIKE', "%" . $email . "%");
        }
        if (isset($search['role_id']) && $search['role_id'] != "") {
            $role_id = $search['role_id'];
            $result = $result->where('role_id', '=', $role_id);
        }
        if(isset($search['status']) && $search['status']!="") 
        {
            $result = $result->where('status','=',$search['status']);
        }
        $result = $result->orderBy('id', 'desc');
        $result = $result->paginate(10);
        
        return $result;
    }
    public static function getVendors() {
        $result = User::where("role_id","=",3)
                ->orderby("firstName","asc")->pluck('firstName', 'id')->prepend("Select","")->all();
        //->where("status","=",1)
        return $result;
    }
    public static function getUser($user_id) {
        $result = User::leftJoin("regions as r", "users.region", "=", "r.id")
                ->leftJoin("cities as c", "users.city", "=", "c.id")
                ->select("users.firstName","users.lastName","users.email","users.mobile as phone","users.address","r.name as regionName", "c.name as cityName")
                ->where("users.id","=",$user_id)->first();
        return $result;
    }
    public function isSuperAdmin()
    {
        return ($this->role_id==1) ? true : false; // this looks for an role_id column in your users table
    }
    public function isAdmin()
    {
        return ($this->role_id==1 || $this->role_id==2) ? true : false; // this looks for an role_id column in your users table
    }
    public function isVendor()
    {
        return ($this->role_id==3 || $this->role_id==4) ? true : false; // this looks for an role_id column in your users table
    }
    public function isCustomer()
    {
        return ($this->role_id==6) ? true : false; // this looks for an role_id column in your users table
    }
}
