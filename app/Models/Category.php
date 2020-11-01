<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products(){
        return $this->hasMany("App\Product");
    }
    public function vendors(){
        return $this->hasMany("App\Vendor");
    }
}
