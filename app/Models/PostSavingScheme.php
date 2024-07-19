<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostSavingScheme extends Model
{
    use HasFactory;

    public function setMaturityDateAttribute($value)
    {
            $this->attributes['maturity_date'] = $value ? Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d') : null;
    }

    public function getMaturityDateAttribute($value)
    {
            return $value ? Carbon::parse($value)->format('m/d/Y') : null;   
    }    


    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'post_saving_scheme_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'post_saving_scheme_joint');
     }

}
