<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model {

    protected $table='complaint';
    public function users() {
        return $this->hasOne('App\User', 'id', 'resolvedBy');
    }
    public static $status=[""=>"Select Status","1"=>"Resolved","2"=>"Unresolved","0"=>"Pending"];
    public static $colors=["1"=>"font-green-jungle","0"=>"font-red-thunderbird","2"=>"font-red"];
    public static $types=[""=>"","Delay in Delivery"=>"Delay in Delivery",
            "Payments"=>"Payments",
            "Damaged"=>"Damaged",
            "Cancel"=>"Cancel",
            "Warranty Claim"=>"Warranty Claim",
            "Replacement"=>"Replacement",
            "Quality Issue"=>"Quality Issue",
            "Wrong Product"=>"Wrong Product",
            "Other"=>"Other"];
}
