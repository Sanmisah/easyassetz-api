<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\ESOP;
use App\Models\Crypto;
use App\Models\Profile;
use App\Models\Debenture;
use App\Models\BankLocker;
use App\Models\Membership;
use App\Models\MutualFund;
use App\Models\BankAccount;
use App\Models\FixDeposite;
use App\Models\ShareDetail;
use App\Models\DematAccount;
use App\Models\BusinessAsset;
use App\Models\LifeInsurance;
use App\Models\OtherDeposite;
use App\Models\BrokingAccount;
use App\Models\InvestmentFund;
use App\Models\MotorInsurance;
use App\Models\OtherInsurance;
use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use App\Models\PostSavingScheme;
use App\Models\OtherFinancialAsset;
use App\Models\PortfolioManagement;
use App\Models\PostalSavingAccount;
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
            $this->attributes['dob'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getDobAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
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

    public function shareDetail(){
        return $this->belongsToMany(ShareDetail::class, 'share_detail_nominee');
    }

    public function mutualFund(){
        return $this->belongsToMany(MutualFund::class, 'mutual_fund_nominee');
    }

    public function debenture(){
        return $this->belongsToMany(Debenture::class, 'debenture_nominee');
    }

    public function bond(){
        return $this->belongsToMany(Bond::class, 'bond_nominee');
    }

    public function esop(){
        return $this->belongsToMany(ESOP::class, 'e_s_o_p_nominee');
    }

    public function dematAccount(){
        return $this->belongsToMany(DematAccount::class, 'demat_account_nominee');
    }

    public function wealthManagement(){
        return $this->belongsToMany(WealthManagementAccount::class, 'wealth_management_nominee');
    }

    public function brokingAccount(){
        return $this->belongsToMany(BrokingAccount::class, 'broking_account_nominee');
    }

    public function businessAsset(){
        return $this->belongsToMany(BusinessAsset::class, 'business_asset_nominee');
    }

    public function investmentFund(){
        return $this->belongsToMany(InvestmentFund::class, 'investment_fund_nominee');
    }

    public function portfolioManagement(){
        return $this->belongsToMany(PortfolioManagement::class, 'portfolio_management_nominee');
    }

    public function otherFinancialAsset(){
        return $this->belongsToMany(OtherFinancialAsset::class, 'other_financial_nominee');
    }

    public function bankAccount(){
        return $this->belongsToMany(BankAccount::class, 'bank_account_nominee');
    }

    public function fixDeposite(){
        return $this->belongsToMany(FixDeposite::class, 'fix_deposite_nominee');
    }

    public function bankLocker(){
        return $this->belongsToMany(BankLocker::class, 'bank_locker_nominee');
    }

    public function postalSavingAccount(){
        return $this->belongsToMany(PostalSavingAccount::class, 'postal_saving_account_nominee');
    }

    public function postSavingScheme(){
        return $this->belongsToMany(PostSavingScheme::class, 'post_saving_scheme_nominee');
    }

    public function otherDeposite(){
        return $this->belongsToMany(OtherDeposite::class, 'other_deposite_nominee');
    }


}
