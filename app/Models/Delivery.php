<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public function pincodes(){
        return $this->hasMany("App\Pincode");
    }
    public function orders(){
        return $this->hasMany("App\Order");
    }
    public function user(){
        return $this->belongsTo("App\User");
    }
}
