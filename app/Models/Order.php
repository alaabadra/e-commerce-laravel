<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function similarProducts(){
        return $this->hasMany("App\SimilarProduct");
    }
    public function Couponcodes(){
        return $this->hasMany("App\Couponcode");
    }
    public function productAttributes(){
        return $this->hasMany("App\ProductAttribute");
    }
    public function delivery(){
        return $this->belongsTo("App\Delivery");
    }
    public function user(){
        return $this->belongsTo("App\User");
    }
    public function productsOrders(){
        return $this->belongsToMany("App\ProductAttributs",'order_product_attrs','order_id','product_attr_id');
    }
}
