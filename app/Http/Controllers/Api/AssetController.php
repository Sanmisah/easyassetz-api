<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use App\Models\AssetModel;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource; // If using resources
use App\Http\Controllers\Api\BaseController; // If BaseController is defined

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
        $alternateInvestmentFund = $profile->investmentFund()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $portfolioManagement = $profile->portfolioManagement()->select(['id', 'fund_name AS fundName', 'folio_number AS folioNumber'])->get();
        $otherFinancialAsset = $profile->otherFinancialAsset()->select(['id', 'bank_service_provider AS bankServiceProvider', 'folio_number AS folioNumber'])->get();

       // Reorganize data into the desired format
$data = [
    [
        'assetName' => 'Insurance',
        'assets' => array_filter([
            [
                'name' => 'Motor Insurance',
                'totalAssets' => $motorInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Health Insurance',
                'totalAssets' => $healthInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Life Insurance',
                'totalAssets' => $lifeInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'General Insurance',
                'totalAssets' => $generalInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Other Insurance',
                'totalAssets' => $otherInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Bullion',
        'assets' => $bullion->map(fn($item) => [
            'id' => $item->id,
            'var1' => $item->metalType,
            'var2' => $item->articleDetails,
        ])->filter()->values(),
    ],
    [
        'assetName' => 'Business Assets',
        'assets' => array_filter([
            [
                'name' => 'Propritorship',
                'totalAssets' => $propritorship->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->firmName,
                    'var2' => $asset->registeredAddress,
                ])->filter()->values(),
            ],
            [
                'name' => 'Partnership Firm',
                'totalAssets' => $partnershipFirm->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->firmName,
                    'var2' => $asset->registeredAddress,
                ])->filter()->values(),
            ],
            [
                'name' => 'Company',
                'totalAssets' => $company->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->companyName,
                    'var2' => $asset->companyAddress,
                ])->filter()->values(),
            ],
            [
                'name' => 'Intellectual Property',
                'totalAssets' => $intellectualProperty->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->typeOfIp,
                    'var2' => $asset->expiryDate,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Membership',
        'assets' => $membership->map(fn($item) => [
            'id' => $item->id,
            'var1' => $item->organizationName,
            'var2' => $item->membershipId,
        ])->filter()->values(),
    ],
    [
        'assetName' => 'Other Assets',
        'assets' => array_filter([
            [
                'name' => 'Vehicles',
                'totalAssets' => $vehicle->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->vehicleType,
                    'var2' => $asset->company,
                ])->filter()->values(),
            ],
            [
                'name' => 'Jewellery',
                'totalAssets' => $jewellery->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->jewelleryType,
                    'var2' => $item->weightPerJewellery,
                ])->filter()->values(),
            ],
            [
                'name' => 'Watches',
                'totalAssets' => $watch->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->company,
                    'var2' => $item->panNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'HUF',
                'totalAssets' => $huf->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->hufName,
                    'var2' => $item->panNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Recoverable',
                'totalAssets' => $recoverable->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->nameOfBorrower,
                    'var2' => $item->address,
                ])->filter()->values(),
            ],
            [
                'name' => 'Other Assets',
                'totalAssets' => $otherAsset->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->nameOfAsset,
                    'var2' => $item->assetDescription,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Digital Assets',
        'assets' => array_filter([
            [
                'name' => 'Crypto',
                'totalAssets' => $crypto->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->cryptoWalletType,
                    'var2' => $item->cryptoWalletAddress,
                ])->filter()->values(),
            ],
            [
                'name' => 'Digital Assets',
                'totalAssets' => $digitalAsset->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->digitalAsset,
                    'var2' => $item->account,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Loans',
        'assets' => array_filter([
            [
                'name' => 'Home Loan',
                'totalAssets' => $homeLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ])->filter()->values(),
            ],
            [
                'name' => 'Personal Loan',
                'totalAssets' => $personalLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ])->filter()->values(),
            ],
            [
                'name' => 'Vehicle Loan',
                'totalAssets' => $vehicleLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ])->filter()->values(),
            ],
            [
                'name' => 'Other Loan',
                'totalAssets' => $otherLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ])->filter()->values(),
            ],
            [
                'name' => 'Litigation',
                'totalAssets' => $litigation->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->litigationType,
                    'var2' => $item->courtName,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Bank',
        'assets' => array_filter([
            [
                'name' => 'Bank Account',
                'totalAssets' => $bankAccount->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->bankName,
                    'var2' => $account->accountType,
                ])->filter()->values(),
            ],
            [
                'name' => 'Fix Deposit',
                'totalAssets' => $fixDeposite->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->fixDepositType,
                    'var2' => $account->bankName,
                ])->filter()->values(),
            ],
            [
                'name' => 'Bank Locker',
                'totalAssets' => $bankLocker->map(fn($locker) => [
                    'id' => $locker->id,
                    'var1' => $locker->bankName,
                    'var2' => $locker->branch,
                ])->filter()->values(),
            ],
            [
                'name' => 'Postal Saving Account Details',
                'totalAssets' => $postalSavingAccount->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->accountNumber,
                    'var2' => $account->postOfficeBranch,
                ])->filter()->values(),
            ],
            [
                'name' => 'Post Saving Scheme',
                'totalAssets' => $postSavingScheme->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->type,
                    'var2' => $account->certificateNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Other Deposit',
                'totalAssets' => $otherDeposite->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->fdNumber,
                    'var2' => $account->company,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Retirement Funds',
        'assets' => array_filter([
            [
                'name' => 'Public Provident Fund',
                'totalAssets' => $publicProvidentFund->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->bankName,
                    'var2' => $fund->ppfAccountNo,
                ])->filter()->values(),
            ],
            [
                'name' => 'Provident Fund',
                'totalAssets' => $providentFund->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->employerName,
                    'var2' => $account->uanNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'NPS',
                'totalAssets' => $nps->map(fn($locker) => [
                    'id' => $locker->id,
                    'var1' => $locker->PRAN,
                    'var2' => $locker->natureOfHolding,
                ])->filter()->values(),
            ],
            [
                'name' => 'Gratuity',
                'totalAssets' => $gratuity->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->employerName,
                    'var2' => $account->employerId,
                ])->filter()->values(),
            ],
            [
                'name' => 'Super Annuation',
                'totalAssets' => $superAnnuation->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->companyName,
                    'var2' => $account->masterPolicyNumber,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Immovable Assets',
        'assets' => array_filter([
            [
                'name' => 'Land',
                'totalAssets' => $land->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->surveyNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Commercial Property',
                'totalAssets' => $commercialProperty->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->houseNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Residential Property',
                'totalAssets' => $residentialProperty->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->houseNumber,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
    [
        'assetName' => 'Financial Assets',
        'assets' => array_filter([
            [
                'name' => 'Shares',
                'totalAssets' => $shareDetail->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->companyName,
                    'var2' => $investment->folioNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Mutual Funds',
                'totalAssets' => $mutualFund->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->fundName,
                    'var2' => $investment->folioNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Debentures',
                'totalAssets' => $debenture->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->bankServiceProvider,
                    'var2' => $investment->companyName,
                ])->filter()->values(),
            ],
            [
                'name' => 'Bonds',
                'totalAssets' => $bond->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->bankServiceProvider,
                    'var2' => $investment->companyName,
                ])->filter()->values(),
            ],
            [
                'name' => 'ESOP',
                'totalAssets' => $esop->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->companyName,
                    'var2' => $investment->unitsGranted,
                ])->filter()->values(),
            ],
            [
                'name' => 'Demant Account',
                'totalAssets' => $dematAccount->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->depositoryName,
                    'var2' => $investment->depositoryId,
                ])->filter()->values(),
            ],
            [
                'name' => 'Wealth Management Account',
                'totalAssets' => $wealthManagementAccount->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->wealthManagerName,
                    'var2' => $investment->accountNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Broking Account',
                'totalAssets' => $brokingAccount->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->brokerName,
                    'var2' => $investment->brokingAccountNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Alternate Investment Fund',
                'totalAssets' => $alternateInvestmentFund->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->fundName,
                    'var2' => $investment->folioNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Portfolio Management Services',
                'totalAssets' => $portfolioManagement->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->fundName,
                    'var2' => $investment->folioNumber,
                ])->filter()->values(),
            ],
            [
                'name' => 'Other Financial Assets',
                'totalAssets' => $otherFinancialAsset->map(fn($investment) => [
                    'id' => $investment->id,
                    'var1' => $investment->bankServiceProvider,
                    'var2' => $investment->folioNumber,
                ])->filter()->values(),
            ],
        ], fn($category) => !$category['totalAssets']->isEmpty()),
    ],
];

$response = [
    'data' => array_values(array_filter($data, fn($category) => !empty($category['assets']))),
];

return response()->json($response);
}
}
