<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Beneficiary;
use Carbon\Carbon;




class AssetModel extends Model
{
    // Define the relationships for the Profile model

    public function motorInsurance()
    {
        return $this->hasMany(MotorInsurance::class);
    }

    public function healthInsurance()
    {
        return $this->hasMany(HealthInsurance::class);
    }

    public function lifeInsurance()
    {
        return $this->hasMany(LifeInsurance::class);
    }

    public function generalInsurance()
    {
        return $this->hasMany(GeneralInsurance::class);
    }

    public function otherInsurance()
    {
        return $this->hasMany(OtherInsurance::class);
    }

    public function bullion()
    {
        return $this->hasMany(Bullion::class);
    }

    public function businessAsset()
    {
        return $this->hasMany(BusinessAsset::class);
    }

    public function membership()
    {
        return $this->hasMany(Membership::class);
    }

    public function otherAsset()
    {
        return $this->hasMany(OtherAsset::class);
    }

    public function crypto()
    {
        return $this->hasMany(Crypto::class);
    }

    public function digitalAsset()
    {
        return $this->hasMany(DigitalAsset::class);
    }

    public function homeLoan()
    {
        return $this->hasMany(HomeLoan::class);
    }

    public function personalLoan()
    {
        return $this->hasMany(PersonalLoan::class);
    }

    public function vehicleLoan()
    {
        return $this->hasMany(VehicleLoan::class);
    }

    public function otherLoan()
    {
        return $this->hasMany(OtherLoan::class);
    }

    public function litigation()
    {
        return $this->hasMany(Litigation::class);
    }

    public function bankAccount()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function fixDeposite()
    {
        return $this->hasMany(FixDeposite::class);
    }

    public function bankLocker()
    {
        return $this->hasMany(BankLocker::class);
    }

    public function postalSavingAccount()
    {
        return $this->hasMany(PostalSavingAccount::class);
    }

    public function postSavingScheme()
    {
        return $this->hasMany(PostSavingScheme::class);
    }

    public function otherDeposite()
    {
        return $this->hasMany(OtherDeposite::class);
    }

    public function publicProvidentFund()
    {
        return $this->hasMany(PublicProvidentFund::class);
    }

    public function providentFund()
    {
        return $this->hasMany(ProvidentFund::class);
    }

    public function nps()
    {
        return $this->hasMany(NPS::class);
    }

    public function gratuity()
    {
        return $this->hasMany(Gratuity::class);
    }

    public function superAnnuation()
    {
        return $this->hasMany(SuperAnnuation::class);
    }

    public function land()
    {
        return $this->hasMany(Land::class);
    }

    public function commercialProperty()
    {
        return $this->hasMany(CommercialProperty::class);
    }

    public function residentialProperty()
    {
        return $this->hasMany(ResidentialProperty::class);
    }

    public function shareDetail()
    {
        return $this->hasMany(ShareDetail::class);
    }

    public function mutualFund()
    {
        return $this->hasMany(MutualFund::class);
    }

    public function debenture()
    {
        return $this->hasMany(Debenture::class);
    }

    public function bond()
    {
        return $this->hasMany(Bond::class);
    }

    public function esop()
    {
        return $this->hasMany(ESOP::class);
    }

    public function dematAccount()
    {
        return $this->hasMany(DematAccount::class);
    }

    public function wealthManagementAccount()
    {
        return $this->hasMany(WealthManagementAccount::class);
    }

    public function brokingAccount()
    {
        return $this->hasMany(BrokingAccount::class);
    }

    public function alternateInvestmentFund()
    {
        return $this->hasMany(AlternateInvestmentFund::class);
    }

    public function portfolioManagement()
    {
        return $this->hasMany(PortfolioManagement::class);
    }

    public function otherFinancialAsset()
    {
        return $this->hasMany(OtherFinancialAsset::class);
    }
    
}

