<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product(){
        return $this->belongsTo("App\Models\Product");
    }
    public function Couponcodes(){
        return $this->hasMany("App\Models\Couponcode");
    }
    public function delivery(){
        return $this->belongsTo("App\Models\Delivery");
    }
    public function user(){
        return $this->belongsTo("App\Models\User");
    }
    public function productsOrders(){
        return $this->belongsToMany("App\Models\Products",'order_products','order_id','product_id');
    }
}
