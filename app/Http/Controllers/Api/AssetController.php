<?php

namespace App\Http\Controllers\Api;

use App\Models\Will;
use App\Models\Profile;
use App\Models\AssetModel;
use App\Models\Beneficiary;
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
    
            $assets = [];
            $insuranceAssets = [];
            $bullionAssets = [];
            $immovableAssetsData = [];
            $businessAssetsData = [];
            $membershipAssets = [];
            $otherAssetsData = [];
            $digitalAssetsData = [];
            $liabilityAssets = [];
            $bankAssets = [];
            $retirementFundAssets =[];
            $financialAssetData =[];


    
            // Helper function to fetch beneficiaries
            $fetchBeneficiaries = function ($assetId, $type, $level) {
                $user = Auth::user();
                $profile = Profile::where('user_id', $user->id)->first(); 
                $will = Will::where('profile_id', $profile->id)->first();
    
                return AssetAllocation::where('asset_id', $assetId)
                    ->where('asset_type', $type)
                    ->where("will_id", $will->id)
                    ->where('level', $level)
                    ->get()
                    ->map(function ($item) {
                        $beneficiary = Beneficiary::find($item->beneficiary_id);
                        return [
                            "id" => $item->beneficiary_id,
                            "fullLegalName" => $beneficiary ? $beneficiary->full_legal_name : null,
                            "Allocation" => $item->allocation,
                            "relationship" => $beneficiary ? $beneficiary->relationship : null,
                        ];
                    });
            };
    
            // Helper function to add asset types to the response
            $addAsset = function ($name, $data, $type, $mainType) use (&$assets, &$insuranceAssets, &$bullionAssets, &$immovableAssetsData, &$businessAssetsData, &$membershipAssets, &$otherAssetsData, &$digitalAssetsData, &$liabilityAssets, &$bankAssets, &$retirementFundAssets, &$financialAssetData, $fetchBeneficiaries) {
                if ($data->isNotEmpty()) {
                    if ($mainType === 'Insurance') {
                        $insuranceAssets[] = [
                            'name' => $name,
                            'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                                return [
                                    'id' => $item->id,
                                    'var1' => $item->companyName ?? $item->company ?? $item->firmName ?? $item->companyName,
                                    'var2' => $item->policyNumber ?? $item->folioNumber ?? $item->accountNumber ?? $item->certificateNumber,
                                    'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                                    'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                                    'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                                    'type' => $type
                                ];
                            })
                        ];
                    } elseif ($mainType === 'Bullion') {
                        $bullionAssets[] = [
                            'name' => $name,
                            'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                                return [
                                    'id' => $item->id,
                                    'var1' => $item->metalType,
                                    'var2' => $item->articleDetails,
                                    'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                                    'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                                    'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                                    'type' => $type
                                ];
                            })
                        ];
                    } elseif ($mainType === 'Immovable Assets') {
                        $immovableAssetsData[] = [
                            'name' => $name,
                            'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                                return [
                                    'id' => $item->id,
                                    'var1' => $item->propertyType,
                                    'var2' => $item->surveyNumber ? $item->surveyNumber : $item->houseNumber,
                                    'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                                    'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                                    'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                                    'type' => $type
                                ];
                            })
                       ];
                } elseif ($mainType === 'Business Assets') {
                    $businessAssetsData[] = [
                        'name' => $name,
                        'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                            return [
                                'id' => $item->id,
                               'var1' => $item->firmName ?? $item->companyName ?? $item->typeOfIp,
                                'var2' => $item->registeredAddress ?? $item->companyAddres ?? $item->expiryDate,
                                'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                                'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                                'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                                'type' => $type
                            ];
                        })
                    ];
                } elseif ($mainType === 'Membership') {
                    $membershipAssets[] = [
                        'name' => $name,
                        'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                            return [
                                'id' => $item->id,
                                'var1' => $item->organizationName,
                                'var2' => $item->membershipId,
                                'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                                'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                                'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                                'type' => $type
                            ];
                        })
                   ];
            }  elseif ($mainType === 'Other Assets') {
                $otherAssetsData[] = [
                    'name' => $name,
                    'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                        return [
                            'id' => $item->id,
                            'var1' => $item->vehicleType ?? $item->jewelleryType ?? $item->company ?? $item->hufName ?? $item->nameOfBorrower ?? $item->nameOfAsset,
                            'var2' => $item->company ?? $item->weightPerJewellery ?? $item->panNumber ?? $item->panNumber ?? $item->address ?? $item->assetDescription,
                            'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                            'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                            'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                            'type' => $type
                        ];
                    })
               ];
           }    elseif ($mainType === 'Digital Assets') {
            $digitalAssetsData[] = [
                'name' => $name,
                'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                    return [
                        'id' => $item->id,
                        'var1' => $item->cryptoWalletType ?? $item->digitalAsset,
                        'var2' => $item->cryptoWalletAddress ?? $item->account,
                        'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                        'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                        'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                        'type' => $type
                    ];
                })
           ];
         } elseif ($mainType === 'Liabilities') {
            $liabilityAssets[] = [
                'name' => $name,
                'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                    return [
                        'id' => $item->id,
                        'var1' => $item->bankName ?? $item->litigationType,
                        'var2' => $item->loanAccountNo ?? $item->courtName,
                        'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                        'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                        'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                        'type' => $type
                    ];
                })
           ];
         } elseif ($mainType === 'Bank') {
            $bankAssets[] = [
                'name' => $name,
                'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                    return [
                        'id' => $item->id,
                        'var1' => $item->bankName ?? $item->fixDepositType ?? $item->bankName ?? $item->accountNumber ??  $item->type ??  $item->fdNumber,
                        'var2' => $item->accountType ?? $item->bankName ?? $item->branch ?? $item->postOfficeBranch ??  $item->certificateNumber ??  $item->company,
                        'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                        'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                        'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                        'type' => $type
                    ];
                })
           ];
         }  elseif ($mainType === 'Retirement Fund') {
            $retirementFundAssets[] = [
                'name' => $name,
                'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                    return [
                        'id' => $item->id,
                        'var1' => $item->bankName ?? $item->employerName ?? $item->PRAN ?? $item->employerName ??  $item->companyName,
                        'var2' => $item->ppfAccountNo ?? $item->uanNumber ?? $item->natureOfHolding ?? $item->employerId ??  $item->masterPolicyNumber,
                        'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                        'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                        'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                        'type' => $type
                    ];
                })
           ];
         }   elseif ($mainType === 'Financial Assets') {
            $financialAssetData[] = [
                'name' => $name,
                'totalAssets' => $data->map(function ($item) use ($type, $fetchBeneficiaries) {
                    return [
                        'id' => $item->id,
                        'var1' => $item->fundName ?? $item->bankName ?? $item->companyName ?? $item->bankServiceProvider ??  $item->depositoryName ?? $item->wealthManagerName ?? $item->brokerName,
                        'var2' => $item->folioNumber ?? $item->companyName ?? $item->unitsGranted ?? $item->depositoryId ??  $item->masterPolicyNumber ?? $item->accountNumber ?? $item->brokingAccountNumber,
                        'primary' => $fetchBeneficiaries($item->id, $type, 'Primary'),
                        'secondary' => $fetchBeneficiaries($item->id, $type, 'Secondary'),
                        'tertiary' => $fetchBeneficiaries($item->id, $type, 'Tertiary'),
                        'type' => $type
                    ];
                })
           ];
         }            

            }
            };
    
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
    
            // Add insurance assets to the main array
            // $addAsset('Motor Insurance', $motorInsurance, 'motorInsurance');
            // $addAsset('Health Insurance', $healthInsurance, 'healthInsurance');
            // $addAsset('Life Insurance', $lifeInsurance, 'lifeInsurance');
            // $addAsset('General Insurance', $generalInsurance, 'generalInsurance');
            // $addAsset('Other Insurance', $otherInsurance, 'otherInsurance');
    
              // Add assets to the respective arrays
        $addAsset('Motor Insurance', $motorInsurance, 'motorInsurance', 'Insurance');
        $addAsset('Health Insurance', $healthInsurance, 'healthInsurance', 'Insurance');
        $addAsset('Life Insurance', $lifeInsurance, 'lifeInsurance', 'Insurance');
        $addAsset('General Insurance', $generalInsurance, 'generalInsurance', 'Insurance');
        $addAsset('Other Insurance', $otherInsurance, 'otherInsurance', 'Insurance');

        $addAsset('Bullion', $bullion, 'bullion', 'Bullion');
        
        $addAsset('Land', $land, 'land', 'Immovable Assets');
        $addAsset('Residential Property', $commercialProperty, 'commercialProperty', 'Immovable Assets');
        $addAsset('Commercial Property', $residentialProperty, 'residentialProperty', 'Immovable Assets');

        $addAsset('Propritorship', $propritorship, 'propritorship', 'Business Assets');
        $addAsset('Partnership Firm', $partnershipFirm, 'partnershipFirm', 'Business Assets');
        $addAsset('Company', $company, 'company', 'Business Assets');
        $addAsset('Intellectual Property', $intellectualProperty, 'intellectualProperty', 'Business Assets');

        $addAsset('Membership', $membership, 'membership', 'Membership');

        $addAsset('Vehicle', $vehicle, 'vehicle', 'Other Assets');
        $addAsset('Huf', $huf, 'huf', 'Other Assets');
        $addAsset('Jewellery', $jewellery, 'jewellery', 'Other Assets');
        $addAsset('Watch', $watch, 'watch', 'Other Assets');
        $addAsset('Recoverable', $recoverable, 'recoverable', 'Other Assets');
      //     add artifact here

      $addAsset('Crypto', $crypto, 'crypto', 'Digital Assets');
      $addAsset('Digital Asset', $digitalAsset, 'digitalAsset', 'Digital Assets');

      $addAsset('Vehicle Loan', $vehicleLoan, 'vehicleLoan', 'Liabilities');
      $addAsset('Home Loan', $homeLoan, 'homeLoan', 'Liabilities');
      $addAsset('Personal Loan', $personalLoan, 'personalLoan', 'Liabilities');
      $addAsset('Other Loan', $otherLoan, 'otherLoan', 'Liabilities');
      $addAsset('Litigation', $litigation, 'litigation', 'Liabilities');

      $addAsset('Bank Account', $bankAccount, 'bankAccount', 'Bank');
      $addAsset('Fix Deposite', $fixDeposite, 'fixDeposite', 'Bank');
      $addAsset('Bank Locker', $bankLocker, 'bankLocker', 'Bank');
      $addAsset('Postal Saving Account', $postalSavingAccount, 'postalSavingAccount', 'Bank');
      $addAsset('Post Saving Scheme', $postSavingScheme, 'postSavingScheme', 'Bank');
      $addAsset('Other Deposit', $otherDeposite, 'otherDeposite', 'Bank');

      $addAsset('Public Provident Fund', $publicProvidentFund, 'publicProvidentFund', 'Retirement Fund');
      $addAsset('Provident Fund', $providentFund, 'providentFund', 'Retirement Fund');
      $addAsset('NPS', $nps, 'nps', 'Retirement Fund');
      $addAsset('Gratuity', $gratuity, 'gratuity', 'Retirement Fund');
      $addAsset('Super Annuation', $superAnnuation, 'superAnnuation', 'Retirement Fund');

      $addAsset('Portfolio Management', $portfolioManagement, 'portfolioManagement', 'Financial Assets');
      $addAsset('Other Financial Asset', $otherFinancialAsset, 'otherFinancialAsset', 'Financial Assets');
      $addAsset('Share Detail', $shareDetail, 'shareDetail', 'Financial Assets');
      $addAsset('Mutual Fund', $mutualFund, 'mutualFund', 'Financial Assets');
      $addAsset('Debenture', $debenture, 'debenture', 'Financial Assets');
      $addAsset('Bond', $bond, 'bond', 'Financial Assets');
      $addAsset('esop', $esop, 'esop', 'Financial Assets');
      $addAsset('Demat Account', $dematAccount, 'dematAccount', 'Financial Assets');
      $addAsset('Wealth Management Account', $wealthManagementAccount, 'wealthManagementAccount', 'Financial Assets');
      $addAsset('Broking Account', $brokingAccount, 'brokingAccount', 'Financial Assets');
      $addAsset('Alternate Investment Fund', $alternateInvestmentFund, 'alternateInvestmentFund', 'Financial Assets');


        // Combine assets into the final structure
        if (!empty($insuranceAssets)) {
            $assets[] = [
                'assetName' => 'Insurance',
                'assets' => $insuranceAssets
            ];
        }
    
        if (!empty($bullionAssets)) {
            $assets[] = [
                'assetName' => 'Bullion',
                'assets' => $bullionAssets
            ];
        }
        
        if (!empty($immovableAssetsData)) {
            $assets[] = [
                'assetName' => 'Immovable Assets',
                'assets' => $immovableAssetsData
            ];
        }

        if (!empty($businessAssetsData)) {
            $assets[] = [
                'assetName' => 'Business Assets',
                'assets' => $businessAssetsData
            ];
        }

        if (!empty($membershipAssets)) {
            $assets[] = [
                'assetName' => 'Membership',
                'assets' => $membershipAssets
            ];
        }

        if (!empty($otherAssetsData)) {
            $assets[] = [
                'assetName' => 'Other Assets',
                'assets' => $otherAssetsData
            ];
        }

        if (!empty($digitalAssetsData)) {
            $assets[] = [
                'assetName' => 'Digital Assets',
                'assets' => $digitalAssetsData
            ];
        }

        if (!empty($liabilityAssets)) {
            $assets[] = [
                'assetName' => 'Liability',
                'assets' => $liabilityAssets
            ];
        }

        if (!empty($bankAssets)) {
            $assets[] = [
                'assetName' => 'Bank And Post',
                'assets' => $bankAssets
            ];
        }

        if (!empty($retirementFundAssets)) {
            $assets[] = [
                'assetName' => 'Retirement Funds',
                'assets' => $retirementFundAssets
            ];
        }

        if (!empty($financialAssetData)) {
            $assets[] = [
                'assetName' => 'Financial Assets',
                'assets' => $financialAssetData
            ];
        }


        // Add other asset types as needed...

        // Respond with the JSON
        return response()->json($assets);
    //     }
    
    // }









        //end
//         // new
//         $data = [];
        
       
     
  
//     $bullionTotalAssets = [];
 
 
//     $motorInsuranceTotalAssets = [];
//      $healthInsuranceTotalAssets = [];    
//      $lifeInsuranceTotalAssets = [];
//      $generalInsuranceTotalAssets = [];
//      $otherInsuranceTotalAssets = [];

//      $propritorshipTotalAssets = [];
//      $partnershipFirmTotalAssets = [];
//      $companyTotalAssets = [];
//      $intellectualPropertyTotalAssets = [];

//         $cryptoTotalAssets = [];
//         $digitalAssetTotalAssets = [];
//         $vehicleTotalAssets = [];
//         $jewelleryTotalAssets = [];
//         $watchTotalAssets = [];
//         $hufTotalAssets = [];
//         $recoverableTotalAssets = [];
//         $otherAssetTotalAssets = [];
//         $vehicleLoanTotalAssets = [];
//         $homeLoanTotalAssets = [];
//         $personalLoanTotalAssets = [];
//         $otherLoanTotalAssets = [];
//         $litigationTotalAssets = [];
//         $bankAccountTotalAssets = [];
//         $fixDepositeTotalAssets = [];
//         $bankLockerTotalAssets = [];
//         $postalSavingAccountTotalAssets = [];
//         $postSavingSchemeTotalAssets = [];
//         $otherDepositeTotalAssets = [];
//         $publicProvidentFundTotalAssets = [];
//         $providentFundTotalAssets = [];
//         $npsTotalAssets = [];
//         $gratuityTotalAssets = [];
//         $superAnnuationTotalAssets = [];
//         $landTotalAssets = [];
//         $commercialPropertyTotalAssets = [];
//         $residentialPropertyTotalAssets = [];
//         $shareDetailTotalAssets = [];
//         $mutualFundTotalAssets = [];
//         $debentureTotalAssets = [];
//         $bondTotalAssets = [];
//         $esopTotalAssets = [];
//         $dematAccountTotalAssets = [];
//         $wealthManagementAccountTotalAssets = [];
//         $brokingAccountTotalAssets = [];
//         $alternateInvestmentFundTotalAssets = [];
//         $portfolioManagementTotalAssets = [];
//         $otherFinancialAssetTotalAssets = [];
//         $membershipTotalAssets = [];

            
// //asasdasddsa
//      $AllAssets = [
//         [
//             ['mainVariable' => $bullion,
//             'variable' => &$bullionTotalAssets,
//             'assetType' => 'bullion',
//             'var1' => 'metalType',
//             'var2' => 'articleDetails',]
//         ],
//         [
//             [
//                 'mainVariable' => $motorInsurance,
//                 'variable' => &$motorInsuranceTotalAssets,
//                 'assetType' => 'motorInsurance',
//                 'var1' => 'companyName',
//                 'var2' => 'policyNumber',
//             ],
//             [
//                 'mainVariable' => $healthInsurance,
//                 'variable' => &$healthInsuranceTotalAssets,
//                 'assetType' => 'healthInsurance',
//                 'var1' => 'companyName',
//                 'var2' => 'policyNumber',
//             ],
//             [
//                 'mainVariable' => $lifeInsurance,
//                 'variable' => &$lifeInsuranceTotalAssets,
//                 'assetType' => 'lifeInsurance',
//                 'var1' => 'companyName',
//                 'var2' => 'policyNumber',
//             ],
//             [
//                 'mainVariable' => $generalInsurance,
//                 'variable' => &$generalInsuranceTotalAssets,
//                 'assetType' => 'generalInsurance',
//                 'var1' => 'companyName',
//                 'var2' => 'policyNumber',
//             ],
//             [
//                 'mainVariable' => $otherInsurance,
//                 'variable' => &$otherInsuranceTotalAssets,
//                 'assetType' => 'otherInsurance',
//                 'var1' => 'companyName',
//                 'var2' => 'policyNumber',
//             ],
//         ],
//         [
//             [
//                 'mainVariable' => $propritorship,
//                 'variable' => &$propritorshipTotalAssets,
//                 'assetType' => 'propritorship',
//                 'var1' => 'firmName',
//                 'var2' => 'registeredAddress',
//             ],
//             [
//                 'mainVariable' => $partnershipFirm,
//                 'variable' => &$partnershipFirmTotalAssets,
//                 'assetType' => 'partnershipFirm',
//                 'var1' => 'firmName',
//                 'var2' => 'registeredAddress',
//             ],
//             [
//                 'mainVariable' => $company,
//                 'variable' => &$companyTotalAssets,
//                 'assetType' => 'company',
//                 'var1' => 'companyName',
//                 'var2' => 'companyAddress',
//             ],
//             [
//                 'mainVariable' => $intellectualProperty,
//                 'variable' => &$intellectualPropertyTotalAssets,
//                 'assetType' => 'intellectualProperty',
//                 'var1' => 'typeOfIp',
//                 'var2' => 'expiryDate',
//             ],
//         ],
//         [
//             [
//                 'mainVariable' => $membership,
//                 'variable' => &$membershipTotalAssets,
//                 'assetType' => 'membership',
//                 'var1' => 'organizationName',
//                 'var2' => 'membershipId',
//             ],

//         ],
//         [
//             [
//                 'mainVariable' => $vehicleLoan,
//                 'variable' => &$vehicleLoanTotalAssets,
//                 'assetType' => 'vehicleLoan',
//                 'var1' => 'bankName',
//                 'var2' => 'loanAccountNo',
//             ],
//             [
//                 'mainVariable' => $homeLoan,
//                 'variable' => &$homeLoanTotalAssets,
//                 'assetType' => 'homeLoan',
//                 'var1' => 'bankName',
//                 'var2' => 'loanAccountNo',
//             ],
//             [
//                 'mainVariable' => $personalLoan,
//                 'variable' => &$personalLoanTotalAssets,
//                 'assetType' => 'personalLoan',
//                 'var1' => 'bankName',
//                 'var2' => 'loanAccountNo',
//             ],
//             [
//                 'mainVariable' => $otherLoan,
//                 'variable' => &$otherLoanTotalAssets,
//                 'assetType' => 'otherLoan',
//                 'var1' => 'bankName',
//                 'var2' => 'loanAccountNo',
//             ],
//             [
//                 'mainVariable' => $litigation,
//                 'variable' => &$litigationTotalAssets,
//                 'assetType' => 'litigation',
//                 'var1' => 'litigationType',
//                 'var2' => 'courtName',
//             ],
                
//         ],
//         [
//             [
//                 'mainVariable' => $portfolioManagement,
//                 'variable' => &$portfolioManagementTotalAssets,
//                 'assetType' => 'portfolioManagement',
//                 'var1' => 'fundName',
//                 'var2' => 'folioNumber',
//             ],
//             [
//                 'mainVariable' => $otherFinancialAsset,
//                 'variable' => &$otherFinancialAssetTotalAssets,
//                 'assetType' => 'otherFinancialAsset',
//                 'var1' => 'bankName',
//                 'var2' => 'folioNumber',
//             ],
//             [
//                 'mainVariable' => $shareDetail,
//                 'variable' => &$shareDetailTotalAssets,
//                 'assetType' => 'shareDetail',
//                 'var1' => 'companyName',
//                 'var2' => 'folioNumber',
//             ],
//             [
//                 'mainVariable' => $mutualFund,
//                 'variable' => &$mutualFundTotalAssets,
//                 'assetType' => 'mutualFund',
//                 'var1' => 'fundName',
//                 'var2' => 'folioNumber',
//             ],
//             [
//                 'mainVariable' => $debenture,
//                 'variable' => &$debentureTotalAssets,
//                 'assetType' => 'debenture',
//                 'var1' => 'bankServiceProvider',
//                 'var2' => 'companyName',
//             ],
//             [
//                 'mainVariable' => $bond,
//                 'variable' => &$bondTotalAssets,
//                 'assetType' => 'bond',
//                 'var1' => 'bankServiceProvider',
//                 'var2' => 'companyName',
//             ],
//             [
//                 'mainVariable' => $esop,
//                 'variable' => &$esopTotalAssets,
//                 'assetType' => 'esop',
//                 'var1' => 'companyName',
//                 'var2' => 'unitsGranted',
//             ],
//             [
//                 'mainVariable' => $dematAccount,
//                 'variable' => &$dematAccountTotalAssets,
//                 'assetType' => 'dematAccount',
//                 'var1' => 'depositoryName',
//                 'var2' => 'depositoryId',
//             ],
//             [
//                 'mainVariable' => $wealthManagementAccount,
//                 'variable' => &$wealthManagementAccountTotalAssets,
//                 'assetType' => 'wealthManagementAccount',
//                 'var1' => 'wealthManagerName',
//                 'var2' => 'accountNumber',
//             ],
//             [
//                 'mainVariable' => $brokingAccount,
//                 'variable' => &$brokingAccountTotalAssets,
//                 'assetType' => 'brokingAccount',
//                 'var1' => 'brokerName',
//                 'var2' => 'brokingAccountNumber',
//             ],
//             [
//                 'mainVariable' => $alternateInvestmentFund,
//                 'variable' => &$alternateInvestmentFundTotalAssets,
//                 'assetType' => 'alternateInvestmentFund',
//                 'var1' => 'fundName',
//                 'var2' => 'folioNumber',
//             ],
//         ],
//         [
//             [
//                 'mainVariable' => $land,
//                 'variable' => &$landTotalAssets,
//                 'assetType' => 'land',
//                 'var1' => 'propertyType',
//                 'var2' => 'surveyNumber',
//             ],
//             [
//                 'mainVariable' => $commercialProperty,
//                 'variable' => &$commercialPropertyTotalAssets,
//                 'assetType' => 'commercialProperty',
//                 'var1' => 'propertyType',
//                 'var2' => 'houseNumber',
//             ],
//             [
//                 'mainVariable' => $residentialProperty,
//                 'variable' => &$residentialPropertyTotalAssets,
//                 'assetType' => 'residentialProperty',
//                 'var1' => 'propertyType',
//                 'var2' => 'houseNumber',
//             ],
//         ],
//         [
//             [
//                 'mainVariable' => $crypto,
//                 'variable' => &$cryptoTotalAssets,
//                 'assetType' => 'crypto',
//                 'var1' => 'cryptoWalletType',
//                 'var2' => 'cryptoWalletAddress',
//             ],
//             [
//                 'mainVariable' => $digitalAsset,
//                 'variable' => &$digitalAssetTotalAssets,
//                 'assetType' => 'digitalAsset',
//                 'var1' => 'digitalAsset',
//                 'var2' => 'account',
//             ],
//         ],
//         [
//             [
//                 'mainVariable' => $vehicle,
//                 'variable' => &$vehicleTotalAssets,
//                 'assetType' => 'vehicle',
//                 'var1' => 'vehicleType',
//                 'var2' => 'company',
//             ],
//             [
//                 'mainVariable' => $jewellery,
//                 'variable' => &$jewelleryTotalAssets,
//                 'assetType' => 'jewellery',
//                 'var1' => 'jewelleryType',
//                 'var2' => 'weightPerJewellery',
//             ],
//             [
//                 'mainVariable' => $watch,
//                 'variable' => &$watchTotalAssets,
//                 'assetType' => 'watch',
//                 'var1' => 'company',
//                 'var2' => 'panNumber',
//             ],
//             [
//                 'mainVariable' => $huf,
//                 'variable' => &$hufTotalAssets,
//                 'assetType' => 'huf',
//                 'var1' => 'hufName',
//                 'var2' => 'panNumber',
//             ],
//             [
//                 'mainVariable' => $recoverable,
//                 'variable' => &$recoverableTotalAssets,
//                 'assetType' => 'recoverable',
//                 'var1' => 'nameOfBorrower',
//                 'var2' => 'address',
//             ],
//             [
//                 'mainVariable' => $otherAsset,
//                 'variable' => &$otherAssetTotalAssets,
//                 'assetType' => 'otherAsset',
//                 'var1' => 'nameOfAsset',
//                 'var2' => 'assetDescription',
//             ],
//         ],
           
//         [
//             [
//                 'mainVariable' => $bankAccount,
//                 'variable' => &$bankAccountTotalAssets,
//                 'assetType' => 'bankAccount',
//                 'var1' => 'bankName',
//                 'var2' => 'accountType',
//             ],
//             [
//                 'mainVariable' => $fixDeposite,
//                 'variable' => &$fixDepositeTotalAssets,
//                 'assetType' => 'fixDeposite',
//                 'var1' => 'fixDepositType',
//                 'var2' => 'bankName',
//             ],
//             [
//                 'mainVariable' => $bankLocker,
//                 'variable' => &$bankLockerTotalAssets,
//                 'assetType' => 'bankLocker',
//                 'var1' => 'bankName',
//                 'var2' => 'branch',
//             ],
//             [
//                 'mainVariable' => $postalSavingAccount,
//                 'variable' => &$postalSavingAccountTotalAssets,
//                 'assetType' => 'postalSavingAccount',
//                 'var1' => 'accountNumber',
//                 'var2' => 'postOfficeBranch',
//             ],  
//             [
//                 'mainVariable' => $postSavingScheme,
//                 'variable' => &$postSavingSchemeTotalAssets,
//                 'assetType' => 'postSavingScheme',
//                 'var1' => 'type',
//                 'var2' => 'certificateNumber',
//             ],
//             [
//                 'mainVariable' => $otherDeposite,
//                 'variable' => &$otherDepositeTotalAssets,
//                 'assetType' => 'otherDeposite',
//                 'var1' => 'fdNumber',
//                 'var2' => 'company',
//             ],
//         ],

//        [
//             [
//                 'mainVariable' => $publicProvidentFund,
//                 'variable' => &$publicProvidentFundTotalAssets,
//                 'assetType' => 'publicProvidentFund',
//                 'var1' => 'bankName',
//                 'var2' => 'ppfAccountNo',
//             ],
//             [
//                 'mainVariable' => $providentFund,
//                 'variable' => &$providentFundTotalAssets,
//                 'assetType' => 'providentFund',
//                 'var1' => 'employerName',
//                 'var2' => 'uanNumber',
//             ],
//             [
//                 'mainVariable' => $nps,
//                 'variable' => &$npsTotalAssets,
//                 'assetType' => 'nps',
//                 'var1' => 'PRAN',
//                 'var2' => 'natureOfHolding',
//             ],
//             [
//                 'mainVariable' => $gratuity,
//                 'variable' => &$gratuityTotalAssets,
//                 'assetType' => 'gratuity',
//                 'var1' => 'employerName',
//                 'var2' => 'employerId',
//             ],
//             [
//                 'mainVariable' => $superAnnuation,
//                 'variable' => &$superAnnuationTotalAssets,
//                 'assetType' => 'superAnnuation',
//                 'var1' => 'companyName',
//                 'var2' => 'masterPolicyNumber',
//             ],
//         ],
        
      
//     ];

//     // Helper function to create the asset allocation
//     function createAllocation($arrayLoop, &$arrayVariable, $type, $var1, $var2)
//     {
//         foreach ($arrayLoop as $item) {
//             $profile_id = auth()->user()->profile->id;
//             $will = Will::where('profile_id', $profile_id)->first();
//             if(!$will){
//                 $will = new Will();
//                 $will->profile_id = auth()->user()->profile->id;
//                 $will->save();
//             }
          
            
//             $will = Will::where('profile_id', $profile_id)->first();
//             $primary = false;
//             $secondary = false;
//             $tertiary = false;
            
//             if($will){
//                 $primary = AssetAllocation::where('asset_id', $item->id)
//                     ->where('asset_type', $type)
//                     ->where('will_id',$will->id)
//                     ->where('level', 'Primary')
//                     ->count();

//                 $secondary = AssetAllocation::where('asset_id', $item->id)
//                     ->where('asset_type', $type)
//                     ->where('will_id',$will->id)
//                     ->where('level', 'Secondary')
//                     ->count();

//                 $tertiary = AssetAllocation::where('asset_id', $item->id)
//                     ->where('asset_type', $type)
//                     ->where('will_id',$will->id)
//                     ->where('level', 'Tertiary')
//                     ->count();
//             }
            
             
            
//             $value1 = $item->$var1;
//             $value2 = $item->$var2;
//             $primary = $primary?true:false;
//             $secondary = $secondary?true:false;
//             $tertiary = $tertiary?true:false;

//             $primaryData = AssetAllocation::where('asset_id', $item->id)
//             ->where('asset_type', $type)
//             ->where('will_id',$will->id)
//             ->where('level', 'Primary')
//             ->get();


//             $PrimaryBeneficiaryData = [];

//             foreach($primaryData as $primaryItem)
//             {
//                 $PrimaryBeneficiaryData[] = [
//                     "id" => $primaryItem->beneficiary_id,
//                     "fullLegalName" => Beneficiary::where('id', $primaryItem->beneficiary_id)->first()->full_legal_name,
//                     "Allocation" => $primaryItem->allocation,
//                     "relationship" => Beneficiary::where('id', $primaryItem->beneficiary_id)->first()->relationship,
//                  ];
//                 }

//                 // start
//                 $secondaryData = AssetAllocation::where('asset_id', $item->id)
//                 ->where('asset_type', $type)
//                 ->where('will_id',$will->id)
//                 ->where('level', 'Secondary')
//                 ->get();

//                 $SecondaryBeneficiaryData = [];
//                 foreach($secondaryData as $secondaryItem)
//                 {
//                     $SecondaryBeneficiaryData[] = [
//                         "id" => $secondaryItem->beneficiary_id,
//                         "fullLegalName" => Beneficiary::where('id', $secondaryItem->beneficiary_id)->first()->full_legal_name,
//                         "Allocation" => $secondaryItem->allocation,
//                         "relationship" => Beneficiary::where('id', $secondaryItem->beneficiary_id)->first()->relationship,
//                      ];
//                     }

//                     // 3
//                  $tertiaryData = AssetAllocation::where('asset_id', $item->id)
//                 ->where('asset_type', $type)
//                 ->where('will_id',$will->id)
//                 ->where('level', 'Tertiary')
//                 ->get();

//                 $TertiaryBeneficiaryData = [];
//                 foreach($tertiaryData as $tertiaryItem)
//                 {
//                     $TertiaryBeneficiaryData[] = [
//                         "id" => $tertiaryItem->beneficiary_id,
//                         "fullLegalName" => Beneficiary::where('id', $tertiaryItem->beneficiary_id)->first()->full_legal_name,
//                         "Allocation" => $tertiaryItem->allocation,
//                         "relationship" => Beneficiary::where('id', $tertiaryItem->beneficiary_id)->first()->relationship,
//                      ];
//                     }
             
//             $arrayVariable[] = [
//                 'id' => $item->id,
//                 'var1' => $value1,
//                 'var2' => $value2,
//                 'primary' => $PrimaryBeneficiaryData,
//                 'secondary' => $SecondaryBeneficiaryData,
//                 'tertiary' => $TertiaryBeneficiaryData,
//                 'type' => $type
//             ];
        
//         }
//     }

//     // Iterate over the $AllAssets array
//     foreach ($AllAssets as &$item) {
//         error_log("Value1: " . print_r($item, true));
//          foreach($item as $items)
//         createAllocation(
//             $items['mainVariable'],
//             $items['variable'],
//             $items['assetType'],
//             $items['var1'],
//             $items['var2']
//         );
//     }
//     unset($item); 

    
//         $data = [];
//         $data= [
//         [ 
//             'assetName' => 'Bullion',
//             'assets' => [
//                 [
//                     'name' => 'Bullion',
//                     'totalAssets' => $bullionTotalAssets,
//                 ],
            
               
//             ],
//         ],
//         [
//             'assetName' => 'Insurance',
//             'assets' => [
//                 [
//                     'name' => 'Motor Insurance',
//                     'totalAssets' => $motorInsuranceTotalAssets,
//                 ],
//                 [
//                     'name' => 'Health Insurance',
//                     'totalAssets' => $healthInsuranceTotalAssets,
//                 ],
//                 [
//                     'name' => 'Life Insurance',
//                     'totalAssets' => $lifeInsuranceTotalAssets,
//                 ],
//                 [
//                     'name' => 'General Insurance',
//                     'totalAssets' => $generalInsuranceTotalAssets,
//                 ],
//                 [
//                     'name' => 'Other Insurance',
//                     'totalAssets' => $otherInsuranceTotalAssets,
//                 ],
//             ],
//         ],
//          [
//             'assetName' => 'Business Assets',
//             'assets' => [
//                 [
//                     'name' => 'Propritorship',
//                     'totalAssets' => $propritorshipTotalAssets,
//                 ],
//                 [
//                     'name' => 'Partnership Firm',
//                     'totalAssets' => $partnershipFirmTotalAssets,
//                 ],
//                 [
//                     'name' => 'Company',
//                     'totalAssets' => $companyTotalAssets,
//                 ],
//                 [
//                     'name' => 'Intellectual Property',
//                     'totalAssets' => $intellectualPropertyTotalAssets,
//                 ],
//             ],
//         ],
//         [
//             'assetName' => 'Immovable Assets',
//             'assets' => [
//                 [
//                     'name' => 'Land',
//                     'totalAssets' => $landTotalAssets,
//                 ],
//                 [
//                     'name' => 'Commercial Property',
//                     'totalAssets' => $commercialPropertyTotalAssets,
//                 ],
//                 [
//                     'name' => 'Residential Property',
//                     'totalAssets' => $residentialPropertyTotalAssets,
//                 ],
//             ],
//         ],
//        [
//             'assetName' => 'Financial Assets',
//             'assets' => [
//                 [
//                     'name' => 'Shares',
//                     'totalAssets' => $shareDetailTotalAssets,
//                 ],
//                 [
//                     'name' => 'Mutual Funds',
//                     'totalAssets' => $mutualFundTotalAssets,
//                 ],
//                 [
//                     'name' => 'Debentures',
//                     'totalAssets' => $debentureTotalAssets,
//                 ],
//                 [
//                     'name' => 'Bonds',
//                     'totalAssets' => $bondTotalAssets,
//                 ],
//                 [
//                     'name' => 'ESOP',
//                     'totalAssets' => $esopTotalAssets,
//                 ],
//                 [
//                     'name' => 'Demant Account',
//                     'totalAssets' => $dematAccountTotalAssets,
//                 ],
//                 [
//                     'name' => 'Wealth Management Account',
//                     'totalAssets' => $wealthManagementAccountTotalAssets,
//                 ],
//                 [
//                     'name' => 'Broking Account',
//                     'totalAssets' => $brokingAccountTotalAssets,
//                 ],
//                 [
//                     'name' => 'Alternate Investment Fund',
//                     'totalAssets' => $alternateInvestmentFundTotalAssets,
//                 ],
//                 [
//                     'name' => 'Portfolio Management Services',
//                     'totalAssets' => $portfolioManagementTotalAssets,
//                 ],
//                 [
//                     'name' => 'Other Financial Assets',
//                     'totalAssets' => $otherFinancialAssetTotalAssets,
//                 ],
//             ],
//         ],
//        [
//                 'assetName' => 'Other Assets',
//                 'assets' => [
//                     [
//                         'name' => 'Vehicle',
//                         'totalAssets' => $vehicleTotalAssets,
//                     ],
//                     [
//                         'name' => 'Jewellery',
//                         'totalAssets' => $jewelleryTotalAssets,
//                     ],
//                     [
//                         'name' => 'Watch',
//                         'totalAssets' => $watchTotalAssets,
//                     ],
//                     [
//                         'name' => 'HUF',
//                         'totalAssets' => $hufTotalAssets,
//                     ],
//                     [
//                         'name' => 'Recoverable',
//                         'totalAssets' => $recoverableTotalAssets,
//                     ],
//                     [
//                         'name' => 'Other Assets',
//                         'totalAssets' => $otherAssetTotalAssets,
//                     ],
//                 ],
//         ],
//         [
//             'assetName' => 'Digital Assets',
//             'assets' => [
//                 [
//                     'name' => 'Crypto',
//                     'totalAssets' => $cryptoTotalAssets,
//                 ],
//                 [
//                     'name' => 'Digital Assets',
//                     'totalAssets' => $digitalAssetTotalAssets,
//                 ],  
                    

//             ],
//         ],
//         [
//             'assetName' => 'Liability',
//             'assets' => [
//                 [
//                     'name' => 'Home Loan',
//                     'totalAssets' => $homeLoanTotalAssets,
//                 ],
//                 [
//                     'name' => 'Vehicle Loan',
//                     'totalAssets' => $vehicleLoanTotalAssets,
//                 ],
//                 [
//                     'name' => 'Personal Loan',
//                     'totalAssets' => $personalLoanTotalAssets,
//                 ],
//                 [
//                     'name' => 'Other Loan',
//                     'totalAssets' => $otherLoanTotalAssets,
//                 ],
//                 [
//                     'name' => 'Litigation',
//                     'totalAssets' => $litigationTotalAssets,
//                 ],
//             ],
//         ],
//             [
//                 'assetName' => 'Bank',
//                 'assets' => [
//                     [
//                         'name' => 'Bank Account',
//                         'totalAssets' => $bankAccountTotalAssets,
//                     ],
//                     [
//                         'name' => 'Fix Deposit',
//                         'totalAssets' => $fixDepositeTotalAssets,
//                     ],
//                     [
//                         'name' => 'Bank Locker',
//                         'totalAssets' => $bankLockerTotalAssets,
//                     ],
//                     [
//                         'name' => 'Postal Saving Account Details',
//                         'totalAssets' => $postalSavingAccountTotalAssets,
//                     ],
//                     [
//                         'name' => 'Post Saving Scheme',
//                         'totalAssets' => $postSavingSchemeTotalAssets,
//                     ],
//                     [
//                         'name' => 'Other Deposit',
//                         'totalAssets' => $otherDepositeTotalAssets,
//                     ],
//                 ],
//             ],
//             [
//                 'assetName' => 'Retirement Funds',
//                 'assets' => [
//                     [
//                         'name' => 'Public Provident Fund',
//                         'totalAssets' => $publicProvidentFundTotalAssets,
//                     ],
//                     [
//                         'name' => 'Provident Fund',
//                         'totalAssets' => $providentFundTotalAssets,
//                     ],
//                     [
//                         'name' => 'NPS',
//                         'totalAssets' => $npsTotalAssets,
//                     ],
//                     [
//                         'name' => 'Gratuity',
//                         'totalAssets' => $gratuityTotalAssets,
//                     ],
//                     [
//                         'name' => 'Super Annuation',
//                         'totalAssets' => $superAnnuationTotalAssets,
//                     ],
//                 ],
//             ],
//             [
//                 'assetName' => 'Membership',
//                 'assets' => [
//                     [
//                         'name' => 'Membership',
//                         'totalAssets' => $membershipTotalAssets,
//                     ],
//                 ],
//             ],
//             [
//                 'assetName' => 'Retirement Funds',
//                 'assets' => [
//                     [
//                         'name' => 'Public Provident Fund',
//                         'totalAssets' => $publicProvidentFundTotalAssets,
//                     ],
//                     [
//                         'name' => 'Provident Fund',
//                         'totalAssets' => $providentFundTotalAssets,
//                     ],
//                     [
//                         'name' => 'NPS',
//                         'totalAssets' => $npsTotalAssets,
//                     ],
//                     [
//                         'name' => 'Gratuity',
//                         'totalAssets' => $gratuityTotalAssets,
//                     ],
//                     [
//                         'name' => 'Super Annuation',
//                         'totalAssets' => $superAnnuationTotalAssets,
//                     ],
//                 ],
//             ],
//         ];

//         return response()->json($data);
    }
}
