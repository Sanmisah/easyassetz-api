<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthInsurance extends Model
{
    use HasFactory;

    
    public function setMaturityDateAttribute($value)
    {
        if($value){
            $this->attributes['maturity_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }                  
    }

    public function getMaturityDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('y/m/d');
        }
    }    




    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'health_insurance_nominee');
     }

     public function familyMember(){
        return $this->belongsToMany(Beneficiary::class,'health_insurance_member');
     }
     
}
