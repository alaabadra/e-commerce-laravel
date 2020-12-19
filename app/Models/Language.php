<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function category(){
        return $this->belongsTo("App\Models\Category");
    }

    public function product(){
        return $this->belongsTo("App\Models\Product");
    }


    public function productAttribute(){
        return $this->belongsTo("App\Models\ProductAttribute");
    }

    public function similarProducts(){
        return $this->belongsTo("App\Models\SimilarProducts");
    }



}
