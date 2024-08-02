<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource;
use App\Http\Controllers\Api\BaseController;
use App\Models\AssetModel;

class AssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $motorInsurance = $user->profile->motorInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $healthInsurance = $user->profile->healthInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $lifeInsurance = $user->profile->lifeInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $generalInsurance = $user->profile->generalInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $otherInsurance = $user->profile->otherInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
       
        $bullion = $user->profile->bullion()->select(['id', 'metal_type AS metalType', 'article_details AS articleDetails'])->get();

        $propritorship = $user->profile->businessAsset()->where('type', 'propritorship')->select(['id', 'registered_address AS registeredAddress', 'firm_name AS firmName'])->get();
        $partnershipFirm = $user->profile->businessAsset()->where('type', 'partnershipFirm')->select(['id', 'registered_address AS registeredAddress', 'firm_name AS firmName'])->get();
        $company = $user->profile->businessAsset()->where('type', 'company')->select(['id', 'company_name AS companyName, company_address AS companyAddress'])->get();
        $intellectualProperty = $user->profile->businessAsset()->where('type', 'intellectualProperty')->select(['id', 'type_of_Ip AS typeOfIp', 'expiry_date AS expiryDate'])->get();

        $membership = $user->profile->membership()->select(['id', 'organization_name AS organizationName', 'membership_id AS membershipId'])->get();

        $vehicle = $user->profile->otherAsset()->where('type', 'vehicle')->select(['id', 'vehicle_type AS vehicleType', 'company AS company'])->get();
        $huf = $user->profile->otherAsset()->where('type', 'huf')->select(['id', 'huf_name AS hufName', 'pan_number AS panNumber'])->get();
        $jewellery = $user->profile->otherAsset()->where('type', 'jewellery')->select(['id', 'jewellery_type AS jewelleryType', 'weight_per_jewellery AS weightPerJewellery'])->get();
        $watch = $user->profile->otherAsset()->where('type', 'watch')->select(['id', 'company AS company', 'pan_number AS panNumber'])->get();
        $artifact = $user->profile->otherAsset()->where('type', 'artifact')->select(['id', 'type_of_artifacts AS typeOfArtifacts', 'number_of_articles AS numberOfArticles'])->get();
        $otherAsset =   $user->profile->otherAsset()->where('type', 'otherAsset')->select(['id', 'name_of_asset AS nameOfAsset', 'asset_description AS assetDescription'])->get();
        $recoverable = $user->profile->otherAsset()->where('type', 'recoverable')->select(['id', 'name_of_borrower AS nameOfBorrower', 'address AS address'])->get();

        $crypto = $user->profile->crypto()->select(['id', 'crypto_wallet_type AS cryptoWalletType', 'crypto_wallet_address AS cryptoWalletAddress'])->get();
        $digitalAsset = $user->profile->digitalAsset()->select(['id', 'digital_asset AS digitalAsset', 'account AS account'])->get();

        $homeLoan = $user->profile->homeLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $personalLoan = $user->profile->personalLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get(); 
        $vehicleLoan = $user->profile->vehicleLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $otherLoan = $user->profile->otherLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $litigation = $user->profile->litigation()->select(['id', 'litigation_type AS litigationType', 'court_name AS courtName'])->get();

        $bankAccount = $user->profile->bankAccount()->select(['id', 'bank_name AS bankName', 'account_type AS accountType'])->get();
        $fixDeposite = $user->profile->fixDeposite()->select(['id', 'fix_deposite_number AS fixDepositeNumber', 'bank_name AS bankName'])->get();
        $bankLocker = $user->profile->bankLocker()->select(['id', 'bank_name AS bankName', 'branch AS branch'])->get();
        $postalSavingAccount = $user->profile->postalSavingAccount()->select(['id', 'account_number AS accountNumber', 'post_office_branch AS postOfficeBranch'])->get();
        $postSavingScheme = $user->profile->postSavingScheme()->select(['id', 'type AS type', 'certificate_number AS certificateNumber'])->get();
        $otherDeposite = $user->profile->otherDeposite()->select(['id', 'fd_number AS fdNumber', 'company AS company'])->get();

        $publicProvidentFund = $user->profile->publicProvidentFund()->select(['id', 'bank_name AS bankName', 'ppf_account_no AS ppfAccountNo'])->get();
        $providentFund = $user->profile->providentFund()->select(['id', 'employer_name AS employerName', 'uan_number AS uanNumber'])->get();
        $nps = $user->profile->nps()->select(['id', 'permanent_retirement_account_no AS PRAN', 'nature_of_holding AS natureOfHolding'])->get();
        $gratuity = $user->profile->gratuity()->select(['id', 'employer_name AS employerName', 'employer_id AS employerId'])->get();
        $superAnnuation = $user->profile->superAnnuation()->select(['id', 'company_name AS companyName', 'master_policy_number AS masterPolicyNumber'])->get();

        $land = $user->profile->land()->select(['id', 'property_type AS propertyType', 'survey_number AS surveyNumber'])->get();
        $commercialProperty = $user->profile->commercialProperty()->select(['id', 'property_type AS propertyType', 'house_number AS houseNumber'])->get();
        $residentialProperty = $user->profile->residentialProperty()->select(['id', 'property_type AS propertyType', 'house_number AS houseNumber'])->get();

        $shareDetail = $user->profile->shareDetail()->select(['id', 'company_name AS companyName', 'folio_number AS folioNumber'])->get();
        $mutualFund = $user->profile->mutualFund()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $debenture = $user->profile->debenture()->select(['id', 'bank_service_provider AS bankServiceProvider', 'company_name AS companyName'])->get();
        $bond = $user->profile->bond()->select(['id', 'bank_service_provider AS bankServiceProvider', 'company_name AS companyName'])->get();
        $esop = $user->profile->esop()->select(['id', 'company_name AS companyName', 'units_granted AS unitsGranted'])->get();
        $dematAccount = $user->profile->dematAccount()->select(['id', 'depository_name AS depositoryName', 'depository_id AS depositoryId'])->get();
        $wealthManagementAccount = $user->profile->wealthManagementAccount()->select(['id', 'wealth_manager_name AS wealthManagerName', 'account_number AS accountNumber'])->get();
        $brokingAccount = $user->profile->brokingAccount()->select(['id', 'broker_name AS brokerName', 'broking_account_number AS brokingAccountNumber'])->get();
        $alternateInvestmentFund = $user->profile->alternateInvestmentFund()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $portfolioManagement = $user->profile->portfolioManagement()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $otherFinancialAsset = $user->profile->otherFinancialAsset()->select(['id', 'bank_service_provider AS bankServiceProvider', 'folio_number AS folioNumber'])->get();
        

        $data = [
            'insurance' => [
                'motor' => $motorInsurance,
                'health' => $healthInsurance,
                'life' => $lifeInsurance,
                'general' => $generalInsurance,
                'other' => $otherInsurance,
            ],
            'bullion' => $bullion,
            'businessAsset' => [
                'propritorship' => $propritorship,
                'partnershipFirm' => $partnershipFirm,
                'company' => $company,
                'intellectualProperty' => $intellectualProperty,
            ],
            'membership' => $membership,
            'otherAsset' => [
                'vehicle' => $vehicle,
                'huf' => $huf,
                'jewellery' => $jewellery,
                'watch' => $watch,
                'artifact' => $artifact,
                'otherAsset' => $otherAsset,
                'recoverable' => $recoverable,
            ],
            'digitalAsset' => [
                'crypto' => $crypto,
                'digitalAsset' => $digitalAsset,
            ],
            'liabilities' => [
                'homeLoan' => $homeLoan,
                'personalLoan' => $personalLoan,
                'vehicleLoan' => $vehicleLoan,
                'otherLoan' => $otherLoan,
                'litigation' => $litigation,
            ],
            'bankAndPost' => [
                'bankAccount' => $bankAccount,
                'fixDeposite' => $fixDeposite,
                'bankLocker' => $bankLocker,
                'postalSavingAccount' => $postalSavingAccount,
                'postSavingScheme' => $postSavingScheme,
                'otherDeposite' => $otherDeposite,
            ],
            'retirementMent' => [
                'publicProvidentFund' => $publicProvidentFund,
                'providentFund' => $providentFund,
                'nps' => $nps,
                'gratuity' => $gratuity,
                'superAnnuation' => $superAnnuation,
            ],
            'immovableAsset' => [
                'land' => $land,
                'commercialProperty' => $commercialProperty,
                'residentialProperty' => $residentialProperty,
            ],
            'financialAsset' => [
                'shareDetail' => $shareDetail,
                'mutualFund' => $mutualFund,
                'debenture' => $debenture,
                'bond' => $bond,
                'esop' => $esop,
                'dematAccount' => $dematAccount,
                'wealthManagementAccount' => $wealthManagementAccount,
                'brokingAccount' => $brokingAccount,
                'alternateInvestmentFund' => $alternateInvestmentFund,
                'portfolioManagement' => $portfolioManagement,
                'otherFinancialAsset' => $otherFinancialAsset,
            ],
        ];
        
        return $this->sendResponse([
        'MotorInsurance'=>$motorInsurance,
        'HealthInsurance'=>$healthInsurance,
        'LifeInsurance'=>$lifeInsurance,
        'GeneralInsurance'=>$generalInsurance,
        'OtherInsurance'=>$otherInsurance],


        " retrived successfully");
    }
}