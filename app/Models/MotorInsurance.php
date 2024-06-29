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


   public function nominee(){
      return $this->belongsToMany(Beneficiary::class,'motor_insurance_nominee');
   }

}
