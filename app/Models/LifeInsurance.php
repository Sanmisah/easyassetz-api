<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifeInsurance extends Model
{
    use HasFactory;

    public $table = 'life_insurances';
    public $primaryKey = 'id';


    public function setMaturityDateAttribute($value)
    {
        if($value){
            $this->attributes['maturity_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getMaturityDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
        }
    }    


   public function nominee(){
      return $this->belongsToMany(Beneficiary::class,'life_insurance_nominee');
   }


}
