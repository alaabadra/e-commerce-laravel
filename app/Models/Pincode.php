<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    public function delivery(){
        return $this->belongsTo("App\Models\Delivery");
    }
}
