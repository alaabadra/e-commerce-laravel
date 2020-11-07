<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public function productAttribute(){
        return $this->belongsTo("App\Models\ProductAttribute");
    }
    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
