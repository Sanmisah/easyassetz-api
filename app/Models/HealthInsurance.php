<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthInsurance extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'health_insurance_nominee');
     }

     public function familyMember(){
        return $this->belongsToMany(Beneficiary::class,'health_insurance_member');
     }
     
}
