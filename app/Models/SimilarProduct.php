<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimilarProduct extends Model
{
    public function order(){
        return $this->belongsTo("App\Order");
    }
    public function productAttribute(){
        return $this->belongsTo("App\ProductAttribute");
    }
}
