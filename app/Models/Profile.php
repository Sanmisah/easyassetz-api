<?php

namespace App\Models;

use App\Models\User;
use App\Models\Crypto;
use App\Models\Bullion;
use App\Models\HomeLoan;
use App\Models\OtherLoan;
use App\Models\Litigation;
use App\Models\Beneficiary;
use App\Models\PersonalLoan;
use App\Models\LifeInsurance;
use App\Models\MotorInsurance;
use App\Models\OtherInsurance;
use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    public function beneficiary(){
        return $this->hasMany(Beneficiary::class, 'profile_id');
    }


    public function charity(){
        return $this->hasMany(Beneficiary::class, 'profile_id');
    }

    public function motorInsurance(){
        return $this->hasMany(MotorInsurance::class, 'profile_id');
    }

    public function lifeInsurance(){
        return $this->hasMany(LifeInsurance::class, 'profile_id');
    }

    public function otherInsurance(){
        return $this->hasMany(OtherInsurance::class, 'profile_id');
    }

    public function healthInsurance(){
        return $this->hasMany(HealthInsurance::class, 'profile_id');
    }

    public function generalInsurance(){
        return $this->hasMany(GeneralInsurance::class, 'profile_id');
    }

    public function bullion(){
        return $this->hasMany(Bullion::class, 'profile_id');
    }

    public function homeLoan(){
        return $this->hasMany(HomeLoan::class, 'profile_id');
    }

    public function personalLoan(){
        return $this->hasMany(PersonalLoan::class, 'profile_id');
    }

    public function otherLoan(){
        return $this->hasMany(OtherLoan::class, 'profile_id');
    }

    public function litigation(){
        return $this->hasMany(Litigation::class, 'profile_id');
    }

    public function crypto(){
        return $this->hasMany(Crypto::class, 'profile_id');
    }

}