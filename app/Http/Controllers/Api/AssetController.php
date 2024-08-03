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
        'assets' => [
            [
                'name' => 'Motor Insurance',
                'totalAssets' => $motorInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ]),
            ],
            [
                'name' => 'Health Insurance',
                'totalAssets' => $healthInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ]),
            ],
            [
                'name' => 'Life Insurance',
                'totalAssets' => $lifeInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ]),
            ],
            [
                'name' => 'General Insurance',
                'totalAssets' => $generalInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ]),
            ],
            [
                'name' => 'Other Insurance',
                'totalAssets' => $otherInsurance->map(fn($insurance) => [
                    'id' => $insurance->id,
                    'var1' => $insurance->companyName,
                    'var2' => $insurance->policyNumber,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Bullion',
        'assets' => $bullion->map(fn($item) => [
            'id' => $item->id,
            'var1' => $item->metalType,
            'var2' => $item->articleDetails,
        ]),
    ],
    [
        'assetName' => 'Business Assets',
        'assets' => [
            [
                'name' => 'Propritorship',
                'totalAssets' => $propritorship->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->firmName,
                    'var2' => $asset->registeredAddress,
                ]),
            ],
            [
                'name' => 'Partnership Firm',
                'totalAssets' => $partnershipFirm->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->firmName,
                    'var2' => $asset->registeredAddress,
                ]),
            ],
            [
                'name' => 'Company',
                'totalAssets' => $company->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->companyName,
                    'var2' => $asset->companyAddress,
                ]),
            ],
            [
                'name' => 'Intellectual Property',
                'totalAssets' => $intellectualProperty->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->typeOfIp,
                    'var2' => $asset->expiryDate,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Membership',
        'assets' => $membership->map(fn($item) => [
            'id' => $item->id,
            'var1' => $item->organizationName,
            'var2' => $item->membershipId,
        ]),
    ],
    [
        'assetName' => 'Other Assets',
        'assets' => [
            [
                'name' => 'Vehicles',
                'totalAssets' => $vehicle->map(fn($asset) => [
                    'id' => $asset->id,
                    'var1' => $asset->vehicleType,
                    'var2' => $asset->company,
                ]),
            ],
            [
                'name' => 'Jewellery',
                'totalAssets' => $jewellery->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->jewelleryType,
                    'var2' => $item->weightPerJewellery,
                ]),
            ],
            [
                'name' => 'Watches',
                'totalAssets' => $watch->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->company,
                    'var2' => $item->panNumber,
                ]),
            ],
            [
                'name' => 'HUF',
                'totalAssets' => $huf->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->hufName,
                    'var2' => $item->panNumber,
                ]),
            ],
            [
                'name' => 'Recoverable',
                'totalAssets' => $recoverable->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->nameOfBorrower,
                    'var2' => $item->address,
                ]),
            ],
            [
                'name' => 'Other Assets',
                'totalAssets' => $otherAsset->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->nameOfAsset,
                    'var2' => $item->assetDescription,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Digital Assets',
        'assets' => [
            [
                'name' => 'Crypto',
                'totalAssets' => $crypto->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->cryptoWalletType,
                    'var2' => $item->cryptoWalletAddress,
                ]),
            ],
            [
                'name' => 'Digital Assets',
                'totalAssets' => $digitalAsset->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->digitalAsset,
                    'var2' => $item->account,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Loans',
        'assets' => [
            [
                'name' => 'Home Loan',
                'totalAssets' => $homeLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ]),
            ],
            [
                'name' => 'Personal Loan',
                'totalAssets' => $personalLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ]),
            ],
            [
                'name' => 'Vehicle Loan',
                'totalAssets' => $vehicleLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ]),
            ],
            [
                'name' => 'Other Loan',
                'totalAssets' => $otherLoan->map(fn($loan) => [
                    'id' => $loan->id,
                    'var1' => $loan->bankName,
                    'var2' => $loan->loanAccountNo,
                ]),
            ],
            [
                'name' => 'Litigation',
                'totalAssets' => $litigation->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->litigationType,
                    'var2' => $item->courtName,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Bank',
        'assets' => [
            [
                'name' => 'Bank Account',
                'totalAssets' => $bankAccount->map(fn($account) => [
                    'id' => $account->id,
                    'var1' => $account->bankName,
                    'var2' => $account->accountType,
                ]),
            ],
            [
                'name' => 'Fix Deposit',
                'totalAssets' => $fixDeposite->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->fixDepositeNumber,
                    'var2' => $item->bankName,
                ]),
            ],
            [
                'name' => 'Bank Locker',
                'totalAssets' => $bankLocker->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->bankName,
                    'var2' => $item->branch,
                ]),
            ],
            [
                'name' => 'Postal Saving Account',
                'totalAssets' => $postalSavingAccount->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->accountNumber,
                    'var2' => $item->postOfficeBranch,
                ]),
            ],
            [
                'name' => 'Other Deposit',
                'totalAssets' => $otherDeposite->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->fdNumber,
                    'var2' => $item->company,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Retirement Funds',
        'assets' => [
            [
                'name' => 'Public Provident Fund',
                'totalAssets' => $publicProvidentFund->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->bankName,
                    'var2' => $fund->ppfAccountNo,
                ]),
            ],
            [
                'name' => 'Provident Fund',
                'totalAssets' => $providentFund->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->employerName,
                    'var2' => $fund->uanNumber,
                ]),
            ],
            [
                'name' => 'NPS',
                'totalAssets' => $nps->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->PRAN,
                    'var2' => $fund->natureOfHolding,
                ]),
            ],
            [
                'name' => 'Gratuity',
                'totalAssets' => $gratuity->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->employerName,
                    'var2' => $fund->employerId,
                ]),
            ],
            [
                'name' => 'Super Annuation',
                'totalAssets' => $superAnnuation->map(fn($fund) => [
                    'id' => $fund->id,
                    'var1' => $fund->companyName,
                    'var2' => $fund->masterPolicyNumber,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Real Estate',
        'assets' => [
            [
                'name' => 'Land',
                'totalAssets' => $land->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->surveyNumber,
                ]),
            ],
            [
                'name' => 'Commercial Property',
                'totalAssets' => $commercialProperty->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->houseNumber,
                ]),
            ],
            [
                'name' => 'Residential Property',
                'totalAssets' => $residentialProperty->map(fn($property) => [
                    'id' => $property->id,
                    'var1' => $property->propertyType,
                    'var2' => $property->houseNumber,
                ]),
            ],
        ],
    ],
    [
        'assetName' => 'Financial Assets',
        'assets' => [
            [
                'name' => 'Shares',
                'totalAssets' => $shareDetail->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->companyName,
                    'var2' => $item->folioNumber,
                ]),
            ],
            [
                'name' => 'Mutual Funds',
                'totalAssets' => $mutualFund->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->fundName,
                    'var2' => $item->folioNumber,
                ]),
            ],
            [
                'name' => 'Debentures',
                'totalAssets' => $debenture->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->bankServiceProvider,
                    'var2' => $item->companyName,
                ]),
            ],
            [
                'name' => 'Bonds',
                'totalAssets' => $bond->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->bankServiceProvider,
                    'var2' => $item->companyName,
                ]),
            ],
            [
                'name' => 'ESOP',
                'totalAssets' => $esop->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->companyName,
                    'var2' => $item->unitsGranted,
                ]),
            ],
            [
                'name' => 'Demat Account',
                'totalAssets' => $dematAccount->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->depositoryName,
                    'var2' => $item->depositoryId,
                ]),
            ],
            [
                'name' => 'Wealth Management Account',
                'totalAssets' => $wealthManagementAccount->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->wealthManagerName,
                    'var2' => $item->accountNumber,
                ]),
            ],
            [
                'name' => 'Broking Account',
                'totalAssets' => $brokingAccount->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->brokerName,
                    'var2' => $item->brokingAccountNumber,
                ]),
            ],
            [
                'name' => 'Alternate Investment Fund',
                'totalAssets' => $alternateInvestmentFund->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->fundName,
                    'var2' => $item->folioNumber,
                ]),
            ],
            [
                'name' => 'Portfolio Management',
                'totalAssets' => $portfolioManagement->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->fundName,
                    'var2' => $item->folioNumber,
                ]),
            ],
            [
                'name' => 'Other Financial Assets',
                'totalAssets' => $otherFinancialAsset->map(fn($item) => [
                    'id' => $item->id,
                    'var1' => $item->bankServiceProvider,
                    'var2' => $item->folioNumber,
                ]),
            ],
        ],
    ],
];

// Return the data in JSON format
return response()->json($data);

        // return $this->sendResponse($data, "Assets retrieved successfully");
    }
}
