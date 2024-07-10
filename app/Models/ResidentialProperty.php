<?php

namespace App\Models;

use App\Models\ResidentialProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResidentialProperty extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(ResidentialProperty::class,'residential_property_nominee');
     }

}
