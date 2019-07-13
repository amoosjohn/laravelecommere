<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guests extends Model
{
    protected $table='guests';
    public static function getGuest($order_id) {
        $result = Guests::leftJoin("regions as r", "guests.region", "=", "r.id")
                ->leftJoin("cities as c", "guests.city", "=", "c.id")
                 ->select("guests.firstName","guests.lastName","guests.email","guests.phone","guests.address","r.name as regionName", "c.name as cityName")
                ->where("order_id","=",$order_id)
                ->first();
        return $result;
    }
}
