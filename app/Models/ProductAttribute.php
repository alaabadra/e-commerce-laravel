<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    public function order(){
        return $this->belongsTo("App\Models\Order");
    }
    public function cart(){
        return $this->belongsTo("App\Models\Cart");
    }

    public function ordersProducts(){
        return $this->belongsToMany("App\Models\Order",'order_product_attrs','product_attr_id','order_id');
    }
    public function favorites(){
        return $this->hasMany("App\Models\Favorite");
    }
    public function languages(){
        return $this->hasMany("App\Models\Language");
    }
}
