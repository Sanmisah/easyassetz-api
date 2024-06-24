<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\ESOP;
use App\Models\Crypto;
use App\Models\Profile;
use App\Models\Debenture;
use App\Models\Membership;
use App\Models\MutualFund;
use App\Models\ShareDetail;
use App\Models\DematAccount;
use App\Models\BusinessAsset;
use App\Models\LifeInsurance;
use App\Models\BrokingAccount;
use App\Models\MotorInsurance;
use App\Models\OtherInsurance;
use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use App\Models\WealthManagementAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiary extends Model
{
    use HasFactory;

    public $table = 'beneficiaries';
    public $primaryKey = 'id';



    public function setDobAttribute($value)
    {
        if($value){
            $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    public function getDobAttribute($value)
    {
        if($value){       //when profile gets created carbon automatically saves date.
            return Carbon::parse($value)->format('yy/m/d');
        }
    }    


    public function motorInsurance(){
        return $this->belongsToMany(MotorInsurance::class, 'motor_insurance_nominee');
    }
    
    public function lifeInsurance(){
        return $this->belongsToMany(LifeInsurance::class, 'life_insurance_nominee');
    }

    public function otherInsurance(){
        return $this->belongsToMany(OtherInsurance::class, 'other_insurance_nominee');
    }

    public function healthInsurance(){
        return $this->belongsToMany(HealthInsurance::class, 'health_insurance_nominee');
    }

    public function healthInsuranceMember(){
        return $this->belongsToMany(HealthInsurance::class, 'health_insurance_member');
    }

  
    public function generalInsurance(){
        return $this->belongsToMany(GeneralInsurance::class, 'general_insurance_nominee');
    }
    
    public function membership(){
        return $this->belongsToMany(Membership::class, 'membership_nominee');
    }

    public function crypto(){
        return $this->belongsToMany(Crypto::class, 'crypto_nominee');
    }

    public function cryptoJointHolder(){
        return $this->belongsToMany(Crypto::class, 'crypto_joint_holder');
    }

    public function shareDetail(){
        return $this->belongsToMany(ShareDetail::class, 'share_detail_nominee');
    }

    public function shareDetailJointHolder(){
        return $this->belongsToMany(ShareDetail::class, 'share_detail_joint_holder');
    }

    public function mutualFund(){
        return $this->belongsToMany(MutualFund::class, 'mutual_fund_nominee');
    }

    public function mutualFundJointHolder(){
        return $this->belongsToMany(MutualFund::class, 'mutual_fund_joint_holder');
    }

    public function debenture(){
        return $this->belongsToMany(Debenture::class, 'debenture_nominee');
    }

    public function debentureJointHolder(){
        return $this->belongsToMany(Debenture::class, 'debenture_joint_holder');
    }

    public function bond(){
        return $this->belongsToMany(Bond::class, 'bond_nominee');
    }

    public function bondJointHolder(){
        return $this->belongsToMany(Bond::class, 'bond_joint_holder');
    }

    public function esop(){
        return $this->belongsToMany(ESOP::class, 'e_s_o_p_nominee');
    }

    public function esopJointHolder(){
        return $this->belongsToMany(ESOP::class, 'e_s_o_p_joint_holder');
    }

    public function dematAccount(){
        return $this->belongsToMany(DematAccount::class, 'demat_account_nominee');
    }

    public function dematAccountJointHolder(){
        return $this->belongsToMany(DematAccount::class, 'demat_account_joint_holder');
    }

    public function wealthManagement(){
        return $this->belongsToMany(WealthManagementAccount::class, 'wealth_management_nominee');
    }

    public function wealthManagementJointHolder(){
        return $this->belongsToMany(WealthManagementAccount::class, 'wealth_management_joint_holder');
    }

    public function brokingAccount(){
        return $this->belongsToMany(BrokingAccount::class, 'broking_account_nominee');
    }

    public function brokingAccountJointHolder(){
        return $this->belongsToMany(BrokingAccount::class, 'broking_account_joint_holder');
    }

    public function businessAsset(){
        return $this->belongsToMany(BusinessAsset::class, 'business_asset_nominee');
    }

    public function businessAssetJointHolder(){
        return $this->belongsToMany(BusinessAsset::class, 'business_asset_joint_holder');
    }


}
