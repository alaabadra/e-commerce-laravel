<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    public function order(){
        return $this->belongsTo("App\Order");
    }
    public function cart(){
        return $this->belongsTo("App\Cart");
    }
    public function similarProducts(){
        return $this->hasMany("App\SimilarProduct");
    }
    public function ordersProducts(){
        return $this->belongsToMany("App\Order",'order_product_attrs','product_attr_id','order_id');
    }
}
