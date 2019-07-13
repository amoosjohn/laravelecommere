<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersDiscounts extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $hidden = ['_token'];
    protected $table = 'orders_discounts';
   
    
    
}
