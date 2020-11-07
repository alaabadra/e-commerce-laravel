<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function similarProducts(){
        return $this->hasMany("App\Models\SimilarProduct");
    }
    public function Couponcodes(){
        return $this->hasMany("App\Models\Couponcode");
    }
    public function productAttributes(){
        return $this->hasMany("App\Models\ProductAttribute");
    }
    public function delivery(){
        return $this->belongsTo("App\Models\Delivery");
    }
    public function user(){
        return $this->belongsTo("App\Models\User");
    }
    public function productsOrders(){
        return $this->belongsToMany("App\Models\ProductAttributs",'order_product_attrs','order_id','product_attr_id');
    }
}
