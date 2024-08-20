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
        return $this->belongsTo(MotorInsurance::class, 'asset_id');
    }

    public function lifeInsurance(){
        return $this->belongsTo(LifeInsurance::class, 'asset_id');
    }

    public function otherInsurance(){
        return $this->belongsTo(OtherInsurance::class, 'asset_id');
    }

    public function healthInsurance(){
        return $this->belongsTo(HealthInsurance::class, 'asset_id');
    }

    public function generalInsurance(){
        return $this->belongsTo(GeneralInsurance::class, 'asset_id');
    }

    public function bullion(){
        return $this->belongsTo(Bullion::class, 'asset_id');
    }

    public function membership(){
        return $this->belongsTo(Membership::class, 'asset_id');
    }

    public function vehicleLoan(){
        return $this->belongsTo(VehicleLoan::class, 'asset_id');
    }

    public function homeLoan(){
        return $this->belongsTo(HomeLoan::class, 'asset_id');
    }

    public function personalLoan(){
        return $this->belongsTo(PersonalLoan::class, 'asset_id');
    }

    public function otherLoan(){
        return $this->belongsTo(OtherLoan::class, 'asset_id');
    }

    public function litigation(){
        return $this->belongsTo(Litigation::class, 'asset_id');
    }

    public function crypto(){
        return $this->belongsTo(Crypto::class, 'asset_id');
    }

    public function shareDetail(){
        return $this->belongsTo(ShareDetail::class, 'asset_id');
    }

    public function mutualFund(){
        return $this->belongsTo(MutualFund::class, 'asset_id');
    }
    
    public function debenture(){
        return $this->belongsTo(Debenture::class, 'asset_id');
    }

    public function bond(){
        return $this->belongsTo(Bond::class, 'asset_id');
    }

    public function dematAccount(){
        return $this->belongsTo(DematAccount::class, 'asset_id');
    }

    public function wealthManagementAccount(){
        return $this->belongsTo(WealthManagement::class, 'asset_id');
    }

    public function brokingAccount(){
        return $this->belongsTo(BrokingAccount::class, 'asset_id');
    }

    public function investmentFund(){
        return $this->belongsTo(InvestmentFund::class, 'asset_id');
    }

    public function businessAsset(){
        return $this->belongsTo(BusinessAsset::class, 'asset_id');
    }

    public function portfolioManagement(){
        return $this->belongsTo(PortfolioManagement::class, 'asset_id');
    }

    public function otherFinancialAsset(){
        return $this->belongsTo(OtherFinancialAsset::class, 'asset_id');
    }

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class, 'asset_id');
    }

    public function fixDeposite(){
        return $this->belongsTo(FixDeposite::class, 'asset_id');
    }

    public function otherAsset(){
        return $this->belongsTo(OtherAsset::class, 'asset_id');
    }

    public function bankLocker(){
        return $this->belongsTo(BankLocker::class, 'asset_id');
    }

    public function postalSavingAccount(){
        return $this->belongsTo(PostalSavingAccount::class, 'asset_id');
    }

    public function postSavingScheme(){
        return $this->belongsTo(PostSavingScheme::class, 'asset_id');
    }
 
    public function otherDeposite(){
        return $this->belongsTo(OtherDeposite::class, 'asset_id');
    }

    public function land(){
        return $this->belongsTo(Land::class, 'asset_id');
    }

    public function publicProvidentFund(){
        return $this->belongsTo(PublicProvidentFund::class, 'asset_id');
    }

    public function providentFund(){
        return $this->belongsTo(ProvidentFund::class, 'asset_id');
    }

    public function nps(){
        return $this->belongsTo(NPS::class, 'asset_id');
    }

    public function gratuity(){
        return $this->belongsTo(Gratuity::class, 'asset_id');
    }

    public function residentialProperty(){
        return $this->belongsTo(ResidentialProperty::class, 'asset_id');
    }

    public function superAnnuation(){
        return $this->belongsTo(SuperAnnuation::class, 'asset_id');
    }

    public function commercialProperty(){
        return $this->belongsTo(CommercialProperty::class, 'asset_id');
    }

    public function digitalAsset(){
        return $this->belongsTo(DigitalAsset::class, 'asset_id');
    }

    public function esop(){
        return $this->belongsTo(ESOP::class, 'asset_id');
    }

    // public function alternateInvestmentFund(){
    //     return $this->belongsTo(InvestmentFund::class, 'asset_id');
    // }



}