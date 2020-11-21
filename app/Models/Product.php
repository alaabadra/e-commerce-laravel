<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category(){
        return $this->belongsTo("App\Models\Category");
    }

    public function ordersProducts(){
        return $this->belongsToMany("App\Models\Products",'orders_products','product_id','order_id');
    }
    public function languages(){
        return $this->hasMany("App\Models\Language");
    }
    public function order(){
        return $this->belongsTo("App\Models\Order");
    }
}
