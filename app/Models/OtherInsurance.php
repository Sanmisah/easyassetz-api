<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherInsurance extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Beneficiary::class, 'other_insurance_nominee');
    }
}
