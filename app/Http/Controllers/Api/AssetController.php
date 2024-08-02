<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Models\AssetModel;
// use App\Http\Resources\AssetResource; // If using resources
// use App\Http\Controllers\Api\BaseController; // If BaseController is defined

class AssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first(); // Assuming Profile model is correctly defined

        if (!$profile) {
            return $this->sendError('Profile not found', [], 404);
        }

        $motorInsurance = $profile->motorInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $healthInsurance = $profile->healthInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $lifeInsurance = $profile->lifeInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $generalInsurance = $profile->generalInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();
        $otherInsurance = $profile->otherInsurance()->select(['id', 'company_name AS companyName', 'policy_number AS policyNumber', 'premium AS premium'])->get();

        $bullion = $profile->bullion()->select(['id', 'metal_type AS metalType', 'article_details AS articleDetails'])->get();

        $propritorship = $profile->businessAsset()->where('type', 'propritorship')->select(['id', 'registered_address AS registeredAddress', 'firm_name AS firmName'])->get();
        $partnershipFirm = $profile->businessAsset()->where('type', 'partnershipFirm')->select(['id', 'registered_address AS registeredAddress', 'firm_name AS firmName'])->get();
        $company = $profile->businessAsset()->where('type', 'company')->select(['id', 'company_name AS companyName, company_address AS companyAddress'])->get();
        $intellectualProperty = $profile->businessAsset()->where('type', 'intellectualProperty')->select(['id', 'type_of_Ip AS typeOfIp', 'expiry_date AS expiryDate'])->get();

        $membership = $profile->membership()->select(['id', 'organization_name AS organizationName', 'membership_id AS membershipId'])->get();

        $vehicle = $profile->otherAsset()->where('type', 'vehicle')->select(['id', 'vehicle_type AS vehicleType', 'company AS company'])->get();
        $huf = $profile->otherAsset()->where('type', 'huf')->select(['id', 'huf_name AS hufName', 'pan_number AS panNumber'])->get();
        $jewellery = $profile->otherAsset()->where('type', 'jewellery')->select(['id', 'jewellery_type AS jewelleryType', 'weight_per_jewellery AS weightPerJewellery'])->get();
        $watch = $profile->otherAsset()->where('type', 'watch')->select(['id', 'company AS company', 'pan_number AS panNumber'])->get();
        $artifact = $profile->otherAsset()->where('type', 'artifact')->select(['id', 'type_of_artifacts AS typeOfArtifacts', 'number_of_articles AS numberOfArticles'])->get();
        $otherAsset = $profile->otherAsset()->where('type', 'otherAsset')->select(['id', 'name_of_asset AS nameOfAsset', 'asset_description AS assetDescription'])->get();
        $recoverable = $profile->otherAsset()->where('type', 'recoverable')->select(['id', 'name_of_borrower AS nameOfBorrower', 'address AS address'])->get();

        $crypto = $profile->crypto()->select(['id', 'crypto_wallet_type AS cryptoWalletType', 'crypto_wallet_address AS cryptoWalletAddress'])->get();
        $digitalAsset = $profile->digitalAsset()->select(['id', 'digital_asset AS digitalAsset', 'account AS account'])->get();

        $homeLoan = $profile->homeLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $personalLoan = $profile->personalLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $vehicleLoan = $profile->vehicleLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $otherLoan = $profile->otherLoan()->select(['id', 'bank_name AS bankName', 'loan_account_no AS loanAccountNo'])->get();
        $litigation = $profile->litigation()->select(['id', 'litigation_type AS litigationType', 'court_name AS courtName'])->get();

        $bankAccount = $profile->bankAccount()->select(['id', 'bank_name AS bankName', 'account_type AS accountType'])->get();
        $fixDeposite = $profile->fixDeposite()->select(['id', 'fix_deposite_number AS fixDepositeNumber', 'bank_name AS bankName'])->get();
        $bankLocker = $profile->bankLocker()->select(['id', 'bank_name AS bankName', 'branch AS branch'])->get();
        $postalSavingAccount = $profile->postalSavingAccount()->select(['id', 'account_number AS accountNumber', 'post_office_branch AS postOfficeBranch'])->get();
        $postSavingScheme = $profile->postSavingScheme()->select(['id', 'type AS type', 'certificate_number AS certificateNumber'])->get();
        $otherDeposite = $profile->otherDeposite()->select(['id', 'fd_number AS fdNumber', 'company AS company'])->get();

        $publicProvidentFund = $profile->publicProvidentFund()->select(['id', 'bank_name AS bankName', 'ppf_account_no AS ppfAccountNo'])->get();
        $providentFund = $profile->providentFund()->select(['id', 'employer_name AS employerName', 'uan_number AS uanNumber'])->get();
        $nps = $profile->nps()->select(['id', 'permanent_retirement_account_no AS PRAN', 'nature_of_holding AS natureOfHolding'])->get();
        $gratuity = $profile->gratuity()->select(['id', 'employer_name AS employerName', 'employer_id AS employerId'])->get();
        $superAnnuation = $profile->superAnnuation()->select(['id', 'company_name AS companyName', 'master_policy_number AS masterPolicyNumber'])->get();

        $land = $profile->land()->select(['id', 'property_type AS propertyType', 'survey_number AS surveyNumber'])->get();
        $commercialProperty = $profile->commercialProperty()->select(['id', 'property_type AS propertyType', 'house_number AS houseNumber'])->get();
        $residentialProperty = $profile->residentialProperty()->select(['id', 'property_type AS propertyType', 'house_number AS houseNumber'])->get();

        $shareDetail = $profile->shareDetail()->select(['id', 'company_name AS companyName', 'folio_number AS folioNumber'])->get();
        $mutualFund = $profile->mutualFund()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $debenture = $profile->debenture()->select(['id', 'bank_service_provider AS bankServiceProvider', 'company_name AS companyName'])->get();
        $bond = $profile->bond()->select(['id', 'bank_service_provider AS bankServiceProvider', 'company_name AS companyName'])->get();
        $esop = $profile->esop()->select(['id', 'company_name AS companyName', 'units_granted AS unitsGranted'])->get();
        $dematAccount = $profile->dematAccount()->select(['id', 'depository_name AS depositoryName', 'depository_id AS depositoryId'])->get();
        $wealthManagementAccount = $profile->wealthManagementAccount()->select(['id', 'wealth_manager_name AS wealthManagerName', 'account_number AS accountNumber'])->get();
        $brokingAccount = $profile->brokingAccount()->select(['id', 'broker_name AS brokerName', 'broking_account_number AS brokingAccountNumber'])->get();
        $alternateInvestmentFund = $profile->alternateInvestmentFund()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $portfolioManagement = $profile->portfolioManagement()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $otherFinancialAsset = $profile->otherFinancialAsset()->select(['id', 'bank_service_provider AS bankServiceProvider', 'folio_number AS folioNumber'])->get();

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
            'loan' => [
                'homeLoan' => $homeLoan,
                'personalLoan' => $personalLoan,
                'vehicleLoan' => $vehicleLoan,
                'otherLoan' => $otherLoan,
                'litigation' => $litigation,
            ],
            'bank' => [
                'bankAccount' => $bankAccount,
                'fixDeposite' => $fixDeposite,
                'bankLocker' => $bankLocker,
                'postalSavingAccount' => $postalSavingAccount,
                'postSavingScheme' => $postSavingScheme,
                'otherDeposite' => $otherDeposite,
            ],
            'providentFund' => [
                'publicProvidentFund' => $publicProvidentFund,
                'providentFund' => $providentFund,
                'nps' => $nps,
                'gratuity' => $gratuity,
                'superAnnuation' => $superAnnuation,
            ],
            'realEstate' => [
                'land' => $land,
                'commercialProperty' => $commercialProperty,
                'residentialProperty' => $residentialProperty,
            ],
            'financial' => [
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

        return $this->sendResponse($data, "Assets retrieved successfully");
    }
}
