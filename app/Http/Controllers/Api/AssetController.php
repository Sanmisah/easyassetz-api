<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use App\Models\AssetModel;
use App\Models\AssetAllocation;
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


        // new
        $data = [];
        
       
     
  
    $bullionTotalAssets = [];
 
 
    $motorInsuranceTotalAssets = [];
     $healthInsuranceTotalAssets = [];    
     $lifeInsuranceTotalAssets = [];
     $generalInsuranceTotalAssets = [];
     $otherInsuranceTotalAssets = [];

     $propritorshipTotalAssets = [];
     $partnershipFirmTotalAssets = [];
     $companyTotalAssets = [];
     $intellectualPropertyTotalAssets = [];

        $cryptoTotalAssets = [];
        $digitalAssetTotalAssets = [];
        $vehicleTotalAssets = [];
        $jewelleryTotalAssets = [];
        $watchTotalAssets = [];
        $hufTotalAssets = [];
        $recoverableTotalAssets = [];
        $otherAssetTotalAssets = [];
        $vehicleLoanTotalAssets = [];
        $homeLoanTotalAssets = [];
        $personalLoanTotalAssets = [];
        $otherLoanTotalAssets = [];
        $litigationTotalAssets = [];
        $bankAccountTotalAssets = [];
        $fixDepositeTotalAssets = [];
        $bankLockerTotalAssets = [];
        $postalSavingAccountTotalAssets = [];
        $postSavingSchemeTotalAssets = [];
        $otherDepositeTotalAssets = [];
        $publicProvidentFundTotalAssets = [];
        $providentFundTotalAssets = [];
        $npsTotalAssets = [];
        $gratuityTotalAssets = [];
        $superAnnuationTotalAssets = [];
        $landTotalAssets = [];
        $commercialPropertyTotalAssets = [];
        $residentialPropertyTotalAssets = [];
        $shareDetailTotalAssets = [];
        $mutualFundTotalAssets = [];
        $debentureTotalAssets = [];
        $bondTotalAssets = [];
        $esopTotalAssets = [];
        $dematAccountTotalAssets = [];
        $wealthManagementAccountTotalAssets = [];
        $brokingAccountTotalAssets = [];
        $alternateInvestmentFundTotalAssets = [];
        $portfolioManagementTotalAssets = [];
        $otherFinancialAssetTotalAssets = [];
        $membershipTotalAssets = [];

            
//asasdasddsa
     $AllAssets = [
        [
            ['mainVariable' => $bullion,
            'variable' => &$bullionTotalAssets,
            'assetType' => 'Bullion',
            'var1' => 'metalType',
            'var2' => 'articleDetails',]
        ],
        [
            [
                'mainVariable' => $motorInsurance,
                'variable' => &$motorInsuranceTotalAssets,
                'assetType' => 'motorInsurance',
                'var1' => 'companyName',
                'var2' => 'policyNumber',
            ],
            [
                'mainVariable' => $healthInsurance,
                'variable' => &$healthInsuranceTotalAssets,
                'assetType' => 'healthInsurance',
                'var1' => 'companyName',
                'var2' => 'policyNumber',
            ],
            [
                'mainVariable' => $lifeInsurance,
                'variable' => &$lifeInsuranceTotalAssets,
                'assetType' => 'lifeInsurance',
                'var1' => 'companyName',
                'var2' => 'policyNumber',
            ],
            [
                'mainVariable' => $generalInsurance,
                'variable' => &$generalInsuranceTotalAssets,
                'assetType' => 'generalInsurance',
                'var1' => 'companyName',
                'var2' => 'policyNumber',
            ],
            [
                'mainVariable' => $otherInsurance,
                'variable' => &$otherInsuranceTotalAssets,
                'assetType' => 'otherInsurance',
                'var1' => 'companyName',
                'var2' => 'policyNumber',
            ],
        ],
        [
            [
                'mainVariable' => $propritorship,
                'variable' => &$propritorshipTotalAssets,
                'assetType' => 'propritorship',
                'var1' => 'firmName',
                'var2' => 'registeredAddress',
            ],
            [
                'mainVariable' => $partnershipFirm,
                'variable' => &$partnershipFirmTotalAssets,
                'assetType' => 'partnershipFirm',
                'var1' => 'firmName',
                'var2' => 'registeredAddress',
            ],
            [
                'mainVariable' => $company,
                'variable' => &$companyTotalAssets,
                'assetType' => 'company',
                'var1' => 'companyName',
                'var2' => 'companyAddress',
            ],
            [
                'mainVariable' => $intellectualProperty,
                'variable' => &$intellectualPropertyTotalAssets,
                'assetType' => 'intellectualProperty',
                'var1' => 'typeOfIp',
                'var2' => 'expiryDate',
            ],
        ],
        [
            [
                'mainVariable' => $membership,
                'variable' => &$membershipTotalAssets,
                'assetType' => 'membership',
                'var1' => 'organizationName',
                'var2' => 'membershipId',
            ],

        ],
        [
            [
                'mainVariable' => $vehicleLoan,
                'variable' => &$vehicleLoanTotalAssets,
                'assetType' => 'vehicleLoan',
                'var1' => 'bankName',
                'var2' => 'loanAccountNo',
            ],
            [
                'mainVariable' => $homeLoan,
                'variable' => &$homeLoanTotalAssets,
                'assetType' => 'homeLoan',
                'var1' => 'bankName',
                'var2' => 'loanAccountNo',
            ],
            [
                'mainVariable' => $personalLoan,
                'variable' => &$personalLoanTotalAssets,
                'assetType' => 'personalLoan',
                'var1' => 'bankName',
                'var2' => 'loanAccountNo',
            ],
            [
                'mainVariable' => $otherLoan,
                'variable' => &$otherLoanTotalAssets,
                'assetType' => 'otherLoan',
                'var1' => 'bankName',
                'var2' => 'loanAccountNo',
            ],
            [
                'mainVariable' => $litigation,
                'variable' => &$litigationTotalAssets,
                'assetType' => 'litigation',
                'var1' => 'litigationType',
                'var2' => 'courtName',
            ],
                
        ],
        [
            [
                'mainVariable' => $portfolioManagement,
                'variable' => &$portfolioManagementTotalAssets,
                'assetType' => 'portfolioManagement',
                'var1' => 'fundName',
                'var2' => 'folioNumber',
            ],
            [
                'mainVariable' => $otherFinancialAsset,
                'variable' => &$otherFinancialAssetTotalAssets,
                'assetType' => 'otherFinancialAsset',
                'var1' => 'bankName',
                'var2' => 'folioNumber',
            ],
            [
                'mainVariable' => $shareDetail,
                'variable' => &$shareDetailTotalAssets,
                'assetType' => 'shareDetail',
                'var1' => 'companyName',
                'var2' => 'folioNumber',
            ],
            [
                'mainVariable' => $mutualFund,
                'variable' => &$mutualFundTotalAssets,
                'assetType' => 'mutualFund',
                'var1' => 'fundName',
                'var2' => 'folioNumber',
            ],
            [
                'mainVariable' => $debenture,
                'variable' => &$debentureTotalAssets,
                'assetType' => 'debenture',
                'var1' => 'bankServiceProvider',
                'var2' => 'companyName',
            ],
            [
                'mainVariable' => $bond,
                'variable' => &$bondTotalAssets,
                'assetType' => 'bond',
                'var1' => 'bankServiceProvider',
                'var2' => 'companyName',
            ],
            [
                'mainVariable' => $esop,
                'variable' => &$esopTotalAssets,
                'assetType' => 'esop',
                'var1' => 'companyName',
                'var2' => 'unitsGranted',
            ],
            [
                'mainVariable' => $dematAccount,
                'variable' => &$dematAccountTotalAssets,
                'assetType' => 'dematAccount',
                'var1' => 'depositoryName',
                'var2' => 'depositoryId',
            ],
            [
                'mainVariable' => $wealthManagementAccount,
                'variable' => &$wealthManagementAccountTotalAssets,
                'assetType' => 'wealthManagementAccount',
                'var1' => 'wealthManagerName',
                'var2' => 'accountNumber',
            ],
            [
                'mainVariable' => $brokingAccount,
                'variable' => &$brokingAccountTotalAssets,
                'assetType' => 'brokingAccount',
                'var1' => 'brokerName',
                'var2' => 'brokingAccountNumber',
            ],
            [
                'mainVariable' => $alternateInvestmentFund,
                'variable' => &$alternateInvestmentFundTotalAssets,
                'assetType' => 'alternateInvestmentFund',
                'var1' => 'fundName',
                'var2' => 'folioNumber',
            ],
        ],
        [
            [
                'mainVariable' => $land,
                'variable' => &$landTotalAssets,
                'assetType' => 'land',
                'var1' => 'propertyType',
                'var2' => 'surveyNumber',
            ],
            [
                'mainVariable' => $commercialProperty,
                'variable' => &$commercialPropertyTotalAssets,
                'assetType' => 'commercialProperty',
                'var1' => 'propertyType',
                'var2' => 'houseNumber',
            ],
            [
                'mainVariable' => $residentialProperty,
                'variable' => &$residentialPropertyTotalAssets,
                'assetType' => 'residentialProperty',
                'var1' => 'propertyType',
                'var2' => 'houseNumber',
            ],
        ],
        [
            [
                'mainVariable' => $crypto,
                'variable' => &$cryptoTotalAssets,
                'assetType' => 'crypto',
                'var1' => 'cryptoWalletType',
                'var2' => 'cryptoWalletAddress',
            ],
            [
                'mainVariable' => $digitalAsset,
                'variable' => &$digitalAssetTotalAssets,
                'assetType' => 'digitalAsset',
                'var1' => 'digitalAsset',
                'var2' => 'account',
            ],
        ],
        [
            [
                'mainVariable' => $vehicle,
                'variable' => &$vehicleTotalAssets,
                'assetType' => 'vehicle',
                'var1' => 'vehicleType',
                'var2' => 'company',
            ],
            [
                'mainVariable' => $jewellery,
                'variable' => &$jewelleryTotalAssets,
                'assetType' => 'jewellery',
                'var1' => 'jewelleryType',
                'var2' => 'weightPerJewellery',
            ],
            [
                'mainVariable' => $watch,
                'variable' => &$watchTotalAssets,
                'assetType' => 'watch',
                'var1' => 'company',
                'var2' => 'panNumber',
            ],
            [
                'mainVariable' => $huf,
                'variable' => &$hufTotalAssets,
                'assetType' => 'huf',
                'var1' => 'hufName',
                'var2' => 'panNumber',
            ],
            [
                'mainVariable' => $recoverable,
                'variable' => &$recoverableTotalAssets,
                'assetType' => 'recoverable',
                'var1' => 'nameOfBorrower',
                'var2' => 'address',
            ],
            [
                'mainVariable' => $otherAsset,
                'variable' => &$otherAssetTotalAssets,
                'assetType' => 'otherAsset',
                'var1' => 'nameOfAsset',
                'var2' => 'assetDescription',
            ],
        ],
           
        [
            [
                'mainVariable' => $bankAccount,
                'variable' => &$bankAccountTotalAssets,
                'assetType' => 'bankAccount',
                'var1' => 'bankName',
                'var2' => 'accountType',
            ],
            [
                'mainVariable' => $fixDeposite,
                'variable' => &$fixDepositeTotalAssets,
                'assetType' => 'fixDeposite',
                'var1' => 'fixDepositType',
                'var2' => 'bankName',
            ],
            [
                'mainVariable' => $bankLocker,
                'variable' => &$bankLockerTotalAssets,
                'assetType' => 'bankLocker',
                'var1' => 'bankName',
                'var2' => 'branch',
            ],
            [
                'mainVariable' => $postalSavingAccount,
                'variable' => &$postalSavingAccountTotalAssets,
                'assetType' => 'postalSavingAccount',
                'var1' => 'accountNumber',
                'var2' => 'postOfficeBranch',
            ],  
            [
                'mainVariable' => $postSavingScheme,
                'variable' => &$postSavingSchemeTotalAssets,
                'assetType' => 'postSavingScheme',
                'var1' => 'type',
                'var2' => 'certificateNumber',
            ],
            [
                'mainVariable' => $otherDeposite,
                'variable' => &$otherDepositeTotalAssets,
                'assetType' => 'otherDeposite',
                'var1' => 'fdNumber',
                'var2' => 'company',
            ],
        ],

       [
            [
                'mainVariable' => $publicProvidentFund,
                'variable' => &$publicProvidentFundTotalAssets,
                'assetType' => 'publicProvidentFund',
                'var1' => 'bankName',
                'var2' => 'ppfAccountNo',
            ],
            [
                'mainVariable' => $providentFund,
                'variable' => &$providentFundTotalAssets,
                'assetType' => 'providentFund',
                'var1' => 'employerName',
                'var2' => 'uanNumber',
            ],
            [
                'mainVariable' => $nps,
                'variable' => &$npsTotalAssets,
                'assetType' => 'nps',
                'var1' => 'PRAN',
                'var2' => 'natureOfHolding',
            ],
            [
                'mainVariable' => $gratuity,
                'variable' => &$gratuityTotalAssets,
                'assetType' => 'gratuity',
                'var1' => 'employerName',
                'var2' => 'employerId',
            ],
            [
                'mainVariable' => $superAnnuation,
                'variable' => &$superAnnuationTotalAssets,
                'assetType' => 'superAnnuation',
                'var1' => 'companyName',
                'var2' => 'masterPolicyNumber',
            ],
        ],
        
      
    ];

    // Helper function to create the asset allocation
    function createAllocation($arrayLoop, &$arrayVariable, $type, $var1, $var2)
    {
        foreach ($arrayLoop as $item) {
            // $allocation = AssetAllocation::where('asset_id', $item->id)->where('asset_type', $type)->first();
      $allocations= AssetAllocation::where('asset_id', $item->id)->where('asset_type', $type)->get();

             foreach($allocations as $allocation){
            $value1 = $item->$var1;
            $value2 = $item->$var2;
            $primary = false;
            $secondary = false;
            $tertiary = false;
            if (isset($allocation) && $allocation->level === "Primary") {
                $primary = true;
            }
             
            if(isset($allocation) && $allocation->level === "Secondary") {
                $secondary = true;
            }
 
            if(isset($allocation) && $allocation->level === "Tertiary") {
                $tertiary = true;
            }
          

            error_log("Value1: " . print_r($value1, true));
            error_log("Value2: " . print_r($value2, true));

        
            $arrayVariable[] = [
                'id' => $item->id,
                'var1' => $value1,
                'var2' => $value2,
                'primary' => $primary,
                'secondary' => $secondary,
                'tertiary' => $tertiary,
            ];
        }
        }
    }

    // Iterate over the $AllAssets array
    foreach ($AllAssets as &$item) {
        error_log("Value1: " . print_r($item, true));
         foreach($item as $items)
        createAllocation(
            $items['mainVariable'],
            $items['variable'],
            $items['assetType'],
            $items['var1'],
            $items['var2']
        );
    }
    unset($item); 

    
        $data = [];
        $data= [
        [ 
            'assetName' => 'Bullion',
            'assets' => [
                [
                    'name' => 'Bullion',
                    'totalAssets' => $bullionTotalAssets,
                ],
            
               
            ],
        ],
        [
            'assetName' => 'Insurance',
            'assets' => [
                [
                    'name' => 'Motor Insurance',
                    'totalAssets' => $motorInsuranceTotalAssets,
                ],
                [
                    'name' => 'Health Insurance',
                    'totalAssets' => $healthInsuranceTotalAssets,
                ],
                [
                    'name' => 'Life Insurance',
                    'totalAssets' => $lifeInsuranceTotalAssets,
                ],
                [
                    'name' => 'General Insurance',
                    'totalAssets' => $generalInsuranceTotalAssets,
                ],
                [
                    'name' => 'Other Insurance',
                    'totalAssets' => $otherInsuranceTotalAssets,
                ],
            ],
        ],
         [
            'assetName' => 'Business Assets',
            'assets' => [
                [
                    'name' => 'Propritorship',
                    'totalAssets' => $propritorshipTotalAssets,
                ],
                [
                    'name' => 'Partnership Firm',
                    'totalAssets' => $partnershipFirmTotalAssets,
                ],
                [
                    'name' => 'Company',
                    'totalAssets' => $companyTotalAssets,
                ],
                [
                    'name' => 'Intellectual Property',
                    'totalAssets' => $intellectualPropertyTotalAssets,
                ],
            ],
        ],
        [
            'assetName' => 'Immovable Assets',
            'assets' => [
                [
                    'name' => 'Land',
                    'totalAssets' => $landTotalAssets,
                ],
                [
                    'name' => 'Commercial Property',
                    'totalAssets' => $commercialPropertyTotalAssets,
                ],
                [
                    'name' => 'Residential Property',
                    'totalAssets' => $residentialPropertyTotalAssets,
                ],
            ],
        ],
       [
            'assetName' => 'Financial Assets',
            'assets' => [
                [
                    'name' => 'Shares',
                    'totalAssets' => $shareDetailTotalAssets,
                ],
                [
                    'name' => 'Mutual Funds',
                    'totalAssets' => $mutualFundTotalAssets,
                ],
                [
                    'name' => 'Debentures',
                    'totalAssets' => $debentureTotalAssets,
                ],
                [
                    'name' => 'Bonds',
                    'totalAssets' => $bondTotalAssets,
                ],
                [
                    'name' => 'ESOP',
                    'totalAssets' => $esopTotalAssets,
                ],
                [
                    'name' => 'Demant Account',
                    'totalAssets' => $dematAccountTotalAssets,
                ],
                [
                    'name' => 'Wealth Management Account',
                    'totalAssets' => $wealthManagementAccountTotalAssets,
                ],
                [
                    'name' => 'Broking Account',
                    'totalAssets' => $brokingAccountTotalAssets,
                ],
                [
                    'name' => 'Alternate Investment Fund',
                    'totalAssets' => $alternateInvestmentFundTotalAssets,
                ],
                [
                    'name' => 'Portfolio Management Services',
                    'totalAssets' => $portfolioManagementTotalAssets,
                ],
                [
                    'name' => 'Other Financial Assets',
                    'totalAssets' => $otherFinancialAssetTotalAssets,
                ],
            ],
        ],
       [
                'assetName' => 'Other Assets',
                'assets' => [
                    [
                        'name' => 'Vehicle',
                        'totalAssets' => $vehicleTotalAssets,
                    ],
                    [
                        'name' => 'Jewellery',
                        'totalAssets' => $jewelleryTotalAssets,
                    ],
                    [
                        'name' => 'Watch',
                        'totalAssets' => $watchTotalAssets,
                    ],
                    [
                        'name' => 'HUF',
                        'totalAssets' => $hufTotalAssets,
                    ],
                    [
                        'name' => 'Recoverable',
                        'totalAssets' => $recoverableTotalAssets,
                    ],
                    [
                        'name' => 'Other Assets',
                        'totalAssets' => $otherAssetTotalAssets,
                    ],
                ],
        ],
        [
            'assetName' => 'Digital Assets',
            'assets' => [
                [
                    'name' => 'Crypto',
                    'totalAssets' => $cryptoTotalAssets,
                ],
                [
                    'name' => 'Digital Assets',
                    'totalAssets' => $digitalAssetTotalAssets,
                ],  
                    

            ],
        ],
        [
            'assetName' => 'Liability',
            'assets' => [
                [
                    'name' => 'Home Loan',
                    'totalAssets' => $homeLoanTotalAssets,
                ],
                [
                    'name' => 'Vehicle Loan',
                    'totalAssets' => $vehicleLoanTotalAssets,
                ],
                [
                    'name' => 'Personal Loan',
                    'totalAssets' => $personalLoanTotalAssets,
                ],
                [
                    'name' => 'Other Loan',
                    'totalAssets' => $otherLoanTotalAssets,
                ],
                [
                    'name' => 'Litigation',
                    'totalAssets' => $litigationTotalAssets,
                ],
            ],
        ],
            [
                'assetName' => 'Bank',
                'assets' => [
                    [
                        'name' => 'Bank Account',
                        'totalAssets' => $bankAccountTotalAssets,
                    ],
                    [
                        'name' => 'Fix Deposit',
                        'totalAssets' => $fixDepositeTotalAssets,
                    ],
                    [
                        'name' => 'Bank Locker',
                        'totalAssets' => $bankLockerTotalAssets,
                    ],
                    [
                        'name' => 'Postal Saving Account Details',
                        'totalAssets' => $postalSavingAccountTotalAssets,
                    ],
                    [
                        'name' => 'Post Saving Scheme',
                        'totalAssets' => $postSavingSchemeTotalAssets,
                    ],
                    [
                        'name' => 'Other Deposit',
                        'totalAssets' => $otherDepositeTotalAssets,
                    ],
                ],
            ],
            [
                'assetName' => 'Retirement Funds',
                'assets' => [
                    [
                        'name' => 'Public Provident Fund',
                        'totalAssets' => $publicProvidentFundTotalAssets,
                    ],
                    [
                        'name' => 'Provident Fund',
                        'totalAssets' => $providentFundTotalAssets,
                    ],
                    [
                        'name' => 'NPS',
                        'totalAssets' => $npsTotalAssets,
                    ],
                    [
                        'name' => 'Gratuity',
                        'totalAssets' => $gratuityTotalAssets,
                    ],
                    [
                        'name' => 'Super Annuation',
                        'totalAssets' => $superAnnuationTotalAssets,
                    ],
                ],
            ],
            [
                'assetName' => 'Membership',
                'assets' => [
                    [
                        'name' => 'Membership',
                        'totalAssets' => $membershipTotalAssets,
                    ],
                ],
            ],
            [
                'assetName' => 'Retirement Funds',
                'assets' => [
                    [
                        'name' => 'Public Provident Fund',
                        'totalAssets' => $publicProvidentFundTotalAssets,
                    ],
                    [
                        'name' => 'Provident Fund',
                        'totalAssets' => $providentFundTotalAssets,
                    ],
                    [
                        'name' => 'NPS',
                        'totalAssets' => $npsTotalAssets,
                    ],
                    [
                        'name' => 'Gratuity',
                        'totalAssets' => $gratuityTotalAssets,
                    ],
                    [
                        'name' => 'Super Annuation',
                        'totalAssets' => $superAnnuationTotalAssets,
                    ],
                ],
            ],
        ];

        return response()->json($data);
    }
}
