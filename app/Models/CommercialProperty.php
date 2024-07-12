<?php

namespace App\Models;

use App\Models\CommercialProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialProperty extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(CommercialProperty::class,'commercial_property_nominee');
     }
     
}
