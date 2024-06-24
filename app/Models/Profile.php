<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\User;
use App\Models\Crypto;
use App\Models\Bullion;
use App\Models\HomeLoan;
use App\Models\Debenture;
use App\Models\OtherLoan;
use App\Models\Litigation;
use App\Models\Membership;
use App\Models\MutualFund;
use App\Models\Beneficiary;
use App\Models\ShareDetail;
use App\Models\VehicleLoan;
use App\Models\DematAccount;
use App\Models\PersonalLoan;
use App\Models\LifeInsurance;
use App\Models\BrokingAccount;
use App\Models\BusinessAssets;
use App\Models\MotorInsurance;

use App\Models\OtherInsurance;

use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use App\Models\AlternateInvestmentFund;
use App\Models\WealthManagementAccount;
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

    public function membership(){
        return $this->hasMany(Membership::class, 'profile_id');
    }

    public function vehicleLoan(){
        return $this->hasMany(VehicleLoan::class, 'profile_id');
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

    public function shareDetail(){
        return $this->hasMany(ShareDetail::class, 'profile_id');
    }

    public function mutualFund(){
        return $this->hasMany(MutualFund::class, 'profile_id');
    }
    
    public function debenture(){
        return $this->hasMany(Debenture::class, 'profile_id');
    }

    public function bond(){
        return $this->hasMany(Bond::class, 'profile_id');
    }

    public function dematAccount(){
        return $this->hasMany(DematAccount::class, 'profile_id');
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDobAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('y/m/d');
        }
    }    

    public function wealthManagementAccount(){
        return $this->hasMany(WealthManagementAccount::class, 'profile_id');
    }

    public function setPassportExpiryDateAttribute($value)
    {
        $this->attributes['passport_expiry_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getPassportExpiryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }    

    public function setDrivingLicenceExpiryDateAttribute($value)
    {
        $this->attributes['passport_expiry_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDrivingLicenceExpiryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }    

    public function brokingAccount(){
        return $this->hasMany(BrokingAccount::class, 'profile_id');
    }

    public function alternateInvestmentFund(){
        return $this->hasMany(AlternateInvestmentFund::class, 'profile_id');
    }

    public function businessAssets(){
        return $this->hasMany(BusinessAssets::class, 'profile_id');
    }

}