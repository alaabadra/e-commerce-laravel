<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function category(){
        return $this->belongsTo("App\Category");
    }
}
