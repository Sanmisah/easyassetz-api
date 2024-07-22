<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherDeposite extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'other_deposite_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'other_deposite_joint_holder');
     }

     public function setMaturityDateAttribute($value)
     {
         if($value === "null") {
             $value = null;
         }
         $this->attributes['maturity_date'] = $value ? Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d') : null;   
     }
 
     public function getMaturityDateAttribute($value)
     {
             return $value ? Carbon::parse($value)->format('m/d/Y') : null;
     }    

}
