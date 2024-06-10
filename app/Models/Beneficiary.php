<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\LifeInsurance;
use App\Models\MotorInsurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiary extends Model
{
    use HasFactory;

    public $table = 'beneficiaries';
    public $primaryKey = 'id';


    public function motorInsurance(){
        return $this->belongsToMany(MotorInsurance::class, 'beneficiary_motor_insurance');//providing pivot table name is optional
    }
    
    public function lifeInsurance(){
        return $this->hasMany(LifeInsurance::class, 'beneficiary_id');
    }

}
