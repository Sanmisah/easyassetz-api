<?php

namespace App\Models;

use App\Models\NPS;
use App\Models\Bond;
use App\Models\ESOP;
use App\Models\Land;
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
use App\Models\DigitalAsset;
use App\Models\PersonalLoan;
use App\Models\BusinessAsset;
use App\Models\LifeInsurance;
use App\Models\OtherDeposite;
use App\Models\ProvidentFund;
use App\Models\BrokingAccount;
use App\Models\InvestmentFund;
use App\Models\MotorInsurance;
use App\Models\OtherInsurance;
use App\Models\SuperAnnuation;
use App\Models\HealthInsurance;
use App\Models\GeneralInsurance;
use App\Models\PostSavingScheme;
use App\Models\WealthManagement;
use App\Models\CommercialProperty;
use App\Models\OtherFinancialAsset;
use App\Models\PortfolioManagement;
use App\Models\PostalSavingAccount;
use App\Models\PublicProvidentFund;
use App\Models\ResidentialProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'will_id',
        'beneficiary_id',
        'asset_id',
        'asset_type',
        'level',
        'allocation',
    ];


    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
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
        return $this->hasMany(WealthManagement::class, 'profile_id');
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

    public function residentialProperty(){
        return $this->hasMany(ResidentialProperty::class, 'profile_id');
    }

    public function superAnnuation(){
        return $this->hasMany(SuperAnnuation::class, 'profile_id');
    }

    public function commercialProperty(){
        return $this->hasMany(CommercialProperty::class, 'profile_id');
    }

    public function digitalAsset(){
        return $this->hasMany(DigitalAsset::class, 'profile_id');
    }

    public function esop(){
        return $this->hasMany(ESOP::class, 'profile_id');
    }



}