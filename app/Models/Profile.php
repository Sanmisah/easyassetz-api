<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\NPS;
use App\Models\Bond;
use App\Models\Land;
use App\Models\User;
use App\Models\Crypto;
use App\Models\Bullion;
use App\Models\Gratuity;
use App\Models\HomeLoan;
use App\Models\Debenture;
use App\Models\OtherLoan;
use App\Models\BankLocker;
use App\Models\Litigation;
use App\Models\Membership;
use App\Models\MutualFund;
use App\Models\OtherAsset;
use App\Models\BankAccount;
use App\Models\Beneficiary;
use App\Models\FixDeposite;
use App\Models\ShareDetail;
use App\Models\VehicleLoan;
use App\Models\DematAccount;
use App\Models\PersonalLoan;
use App\Models\BusinessAsset;
use App\Models\LifeInsurance;
use App\Models\OtherDeposite;
use App\Models\ProvidentFund;
use App\Models\BrokingAccount;
use App\Models\BusinessAssets;
use App\Models\InvestmentFund;
use App\Models\MotorInsurance;
use App\Models\OtherInsurance;
use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use App\Models\PostSavingScheme;
use App\Models\OtherFinancialAsset;
use App\Models\PortfolioManagement;
use App\Models\PostalSavingAccount;
use App\Models\PublicProvidentFund;
use App\Models\WealthManagementAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;


    public function setDobAttribute($value)
    {
            $this->attributes['dob'] = $value ? Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d') : null;
    }

    public function getDobAttribute($value)
    {
            return $value ? Carbon::parse($value)->format('m/d/Y') : null;   
    }    

    public function setPanNumberAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['pan_number'] = $value ? $value : null;
    }

    public function getPanNumberAttribute($value)
    {
            return $value ? $value : null;   
    }   
    
    public function setadharNumberAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['adhar_number'] = $value ? $value : null;
    }

    public function getadharNumberAttribute($value)
    {
            return $value ? $value : null;   
    }   

    public function setadharNameAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['adhar_name'] = $value ? $value : null;
    }

    public function getadharNameAttribute($value)
    {
            return $value ? $value : null;   
    }   

    public function setPanNameAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['pan_name'] = $value ? $value : null;
    }

    public function getPanNameAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setPassportNumberAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['passport_number'] = $value ? $value : null;
    }

    public function getPassportNumberAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setPassportNameAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['passport_name'] = $value ? $value : null;
    }

    public function getPassportNameAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setPassportPlaceOfIssueAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['passport_place_of_issue'] = $value ? $value : null;
    }

    public function getPassportPlaceOfIssueAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setDrivingLicenceNumberAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['driving_licence_number'] = $value ? $value : null;
    }

    public function getDrivingLicenceNumberAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setDrivingLicenceNameAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['driving_licence_name'] = $value ? $value : null;
    }

    public function getDrivingLicenceNameAttribute($value)
    {
            return $value ? $value : null;   
    }    

    public function setDrivingLicencePlaceOfIssueAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
            $this->attributes['driving_licence_place_of_issue'] = $value ? $value : null;
    }

    public function getDrivingLicencePlaceOfissueAttribute($value)
    {
            return $value ? $value : null;   
    }    


    public function setPassportExpiryDateAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
        $this->attributes['passport_expiry_date'] = !empty($value) ? Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d') : null;
    }

    

   
    public function getPassportExpiryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('m/d/Y') : null;    
    }    

    public function setDrivingLicenceExpiryDateAttribute($value)
    {
        if($value === "null") {
            $value = null;
        }
        $this->attributes['driving_licence_expiry_date'] = $value ? Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d') : null;   
    }

    public function getDrivingLicenceExpiryDateAttribute($value)
    {
            return $value ? Carbon::parse($value)->format('m/d/Y') : null;
    }    




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

    public function wealthManagementAccount(){
        return $this->hasMany(WealthManagementAccount::class, 'profile_id');
    }

    public function brokingAccount(){
        return $this->hasMany(BrokingAccount::class, 'profile_id');
    }

    public function investmentFund(){
        return $this->hasMany(InvestmentFund::class, 'profile_id');
    }

    public function businessAsset(){
        return $this->hasMany(BusinessAsset::class, 'profile_id');
    }

    public function portfolioManagement(){
        return $this->hasMany(PortfolioManagement::class, 'profile_id');
    }

    public function otherFinancialAsset(){
        return $this->hasMany(OtherFinancialAsset::class, 'profile_id');
    }

    public function bankAccount(){
        return $this->hasMany(BankAccount::class, 'profile_id');
    }

    public function fixDeposite(){
        return $this->hasMany(FixDeposite::class, 'profile_id');
    }

    public function otherAsset(){
        return $this->hasMany(OtherAsset::class, 'profile_id');
    }

    public function bankLocker(){
        return $this->hasMany(BankLocker::class, 'profile_id');
    }

    public function postalSavingAccount(){
        return $this->hasMany(PostalSavingAccount::class, 'profile_id');
    }

    public function postSavingScheme(){
        return $this->hasMany(PostSavingScheme::class, 'profile_id');
    }
 
    public function otherDeposite(){
        return $this->hasMany(OtherDeposite::class, 'profile_id');
    }

    public function land(){
        return $this->hasMany(Land::class, 'profile_id');
    }

    public function publicProvidentFund(){
        return $this->hasMany(PublicProvidentFund::class, 'profile_id');
    }

    public function providentFund(){
        return $this->hasMany(ProvidentFund::class, 'profile_id');
    }

    public function nps(){
        return $this->hasMany(NPS::class, 'profile_id');
    }

    public function gratuity(){
        return $this->hasMany(Gratuity::class, 'profile_id');
    }

}
