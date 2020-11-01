<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productAttributes(){
        return $this->hasMany("App\ProductAttribute");
    }
    public function category(){
        return $this->belongsTo("App\Category");
    }
    public function favorites(){
        return $this->hasMany("App\Favorite");
    }
    public function ordersProducts(){
        return $this->belongsToMany("App\ProductAttributs",'orders_products','product_id','order_id');
    }
}
