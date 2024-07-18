<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorInsurance extends Model
{
    use HasFactory;

    public $table = 'motor_insurances';
    public $primaryKey = 'id';

    public function setExpiryDateAttribute($value)
    {
        if($value){
            $this->attributes['expiry_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getExpiryDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
        }
    }    

    public function setRegisteredEmailAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
        return $this->attributes['registered_email'] = $value ? $value : null;
    }

    public function getRegisteredEmailAttribute($value)
    {
        return $value ? $value : null;     
    }   
    
    public function setRegisteredMobileAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
        return $this->attributes['registered_mobile'] = $value ? $value : null;
    }

    public function getRegisteredMobileAttribute($value)
    {
        return $value ? $value : null;     
    }   


    public function setImageAttribute($value)
    {
        if($value === "undefined") {
            $value = null;
        }
        return $this->attributes['image'] = $value ? $value : null;
    }

    public function getImageAttribute($value)
    {
        return $value ? $value : null;     
    }   


   public function nominee(){
      return $this->belongsToMany(Beneficiary::class,'motor_insurance_nominee');
   }

}
