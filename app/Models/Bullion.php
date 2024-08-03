<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bullion extends Model
{
    use HasFactory;
}

// $assets = [
    //     'motor_insurance' => 'Motor Insurance',
    //     'life_insurance' => 'Life Insurance',
    //     'other_insurance' => 'Other Insurance',
    //     'health_insurance' => 'Health Insurance',
    //     'general_insurance' => 'General Insurance',
    //     'bullion' => 'Bullion',
    //     'propirtership' => 'Propirtership',
    //     'partnership_firm' => 'Partnership Firm',
    //     'company' => 'Company',
    //     'intellectual_property' => 'Intellectual Property',
    //     'membership' => 'Membership',
    //     'vehicle' => 'Vehicle',
    //     'huf' => 'Huf',
    //     'jewellery' => 'Jewellery',
    //     'watch' => 'Watch',
    //     'artifact' => 'Artifact',
    //     'other_asset' => 'Other Asset',
    //     'recoverable' => 'Recoverable',
    //     'crypto' => 'Crypto',
    //     'digital_asset' => 'Digital Asset',
    //     'vehicle_loan' => 'Vehicle Loan',
    //     'home_loan' => 'Home Loan',
    //     'personal_loan' => 'Personal Loan',
    //     'other_loan' => 'Other Loan',
    //     'litigation' => 'Litigation',
    //     'bank_locker' => 'Bank Locker',
    //     'bank_account' => 'Bank Account',
    //     'fix_deposite' => 'Fix Deposite',
    //     'postal_saving_account' => 'Postal Saving Account',
    //     'post_saving_scheme' => 'Post Saving Scheme',
    //     'other_deposite' => 'Other Deposite',
    //     'public_provident_fund' => 'Public Provident Fund',
    //     'provident_fund' => 'Provident Fund',
    //     'nps' => 'NPS',
    //     'gratuity' => 'Gratuity',
    //     'super_annuation' => 'Super Annuation',
    //     'land' => 'Land',
    //     'residential_property' => 'Residential Property',
    //     'commercial_property' => 'Commercial Property',
    //     'share_detail' => 'Share Detail',
    //     'mutual_fund' => 'Mutual Fund',
    //     'debenture' => 'Debenture',
    //     'bond' => 'Bond',
    //     'esop' => 'ESOP',
    //     'demat_account' => 'Demat Account',
    //     'wealth_management_account' => 'Wealth Management Account',
    //     'broking_account' => 'Broking Account',
    //     'alternate_investment_fund' => 'Alternate Investment Fund',
    //     'portfolio_management' => 'Portfolio Management',
    //     'other_financial_asset' => 'Other Financial Asset',
    // ];           

// $assets = [
//     'motor_insurance' => 'MotorInsurance',
//     'life_insurance' => 'LifeInsurance',
//     'other_insurance' => 'OtherInsurance',
//     'health_insurance' => 'HealthInsurance',
//     'general_insurance' => 'GeneralInsurance',
//     'bullion' => 'Bullion',
//     'propirtership' => 'Propirtership',
//     'partnership_firm' => 'PartnershipFirm',
//     'company' => 'Company',
//     'intellectual_property' => 'IntellectualProperty',
//     'membership' => 'Membership',
//     'vehicle' => 'Vehicle',
//     'huf' => 'Huf',
//     'jewellery' => 'Jewellery',
//     'watch' => 'Watch',
//     'artifact' => 'Artifact',
//     'other_asset' => 'OtherAsset',
//     'recoverable' => 'Recoverable',
//     'crypto' => 'Crypto',
//     'digital_asset' => 'DigitalAsset',
//     'vehicle_loan' => 'VehicleLoan',
//     'home_loan' => 'HomeLoan',
//     'personal_loan' => 'PersonalLoan',
//     'other_loan' => 'OtherLoan',
//     'litigation' => 'Litigation',
//     'bank_locker' => 'BankLocker',
//     'bank_account' => 'BankAccount',
//     'fix_deposite' => 'FixDeposite',
//     'postal_saving_account' => 'PostalSavingAccount',
//     'post_saving_scheme' => 'PostSavingScheme',
//     'other_deposite' => 'OtherDeposite',
//     'public_provident_fund' => 'PublicProvidentFund',
//     'provident_fund' => 'ProvidentFund',
//     'nps' => 'NPS',
//     'gratuity' => 'Gratuity',
//     'super_annuation' => 'SuperAnnuation',
//     'land' => 'Land',
//     'residential_property' => 'ResidentialProperty',
//     'commercial_property' => 'CommercialProperty',
//     'share_detail' => 'ShareDetail',
//     'mutual_fund' => 'MutualFund',
//     'debenture' => 'Debenture',
//     'bond' => 'Bond',
//     'esop' => 'ESOP',
//     'demat_account' => 'DematAccount',
//     'wealth_management_account' => 'WealthManagementAccount',
//     'broking_account' => 'BrokingAccount',
//     'alternate_investment_fund' => 'AlternateInvestmentFund',
//     'portfolio_management' => 'PortfolioManagement',
//     'other_financial_asset' => 'OtherFinancialAsset',
// ];


//   $Allassets = [
//     {
//       assetName: "Other Assets",
//       assets: [
//         {
//           name: "vehicles",
//           totalAssets: otherassets?.Vehicle?.map((vehicle) => ({
//             var1: vehicle.registrationNumber,
//             var2: vehicle.vehicleType,
//             data: vehicle,
//           })),
//         },
//         {
//           name: "jewellery",
//           totalAssets: otherassets?.Jewellery?.map((jewellery) => ({
//             var1: jewellery.jewelleryType,
//             var2: jewellery.quantity,
//             data: jewellery,
//           })),
//         },
//         {
//           name: "watches",
//           totalAssets: otherassets?.Watch?.map((watch) => ({
//             var1: watch.company,
//             var2: watch.model,
//             data: watch,
//           })),
//         },
//         // {
//         //   name: "artifacts",
//         //   totalAssets: otherassets?.Artifacts?.map((artifact) => ({
//         //     var1: artifact.registrationNumber,
//         //     var2: artifact.artifactType,
//         //     data: artifact,
//         //   })),
//         // },
//         {
//           name: "huf",
//           totalAssets: otherassets?.HUF?.map((huf) => ({
//             var1: huf.hufName,
//             var2: huf.panNumber,
//             data: huf,
//           })),
//         },
//         {
//           name: "recoverable",
//           totalAssets: otherassets?.Recoverable?.map((recoverable) => ({
//             var1: recoverable.nameOfBorrower,
//             var2: recoverable.modeOfLoan,
//             data: recoverable,
//           })),
//         },
//         {
//           name: "otherAssets",
//           totalAssets: otherassets?.OtherAsset?.map((otherAsset) => ({
//             var1: otherAsset.nameOfAsset,
//             var2: otherAsset.assetDescription,
//             data: otherAsset,
//           })),
//         },
//       ],
//     },
//   ];



//   $data = [
//     [
//         'assetName' => 'Insurance',
//         'assets' => [
//             ['name' => 'Motor', 'totalAssets' => $motorInsurance->map(fn($insurance) => [
//                 'var1' => $insurance->companyName,
//                 'var2' => $insurance->policyNumber,
//                 'data' => $insurance
//             ])],
//             ['name' => 'Health', 'totalAssets' => $healthInsurance->map(fn($insurance) => [
//                 'var1' => $insurance->companyName,
//                 'var2' => $insurance->policyNumber,
//                 'data' => $insurance
//             ])],
//             ['name'




//             // Reorganize data into the desired format
// $data = [
//     [
//         'assetName' => 'Insurance',
//         'assets' => [
//             [
//                 'name' => 'Motor',
//                 'totalAssets' => $motorInsurance->map(fn($insurance) => [
//                     'var1' => $insurance->companyName,
//                     'var2' => $insurance->policyNumber,
//                     'data' => $insurance,
//                 ]),
//             ],
//             [
//                 'name' => 'Health',
//                 'totalAssets' => $healthInsurance->map(fn($insurance) => [
//                     'var1' => $insurance->companyName,
//                     'var2' => $insurance->policyNumber,
//                     'data' => $insurance,
//                 ]),
//             ],
//             [
//                 'name' => 'Life',
//                 'totalAssets' => $lifeInsurance->map(fn($insurance) => [
//                     'var1' => $insurance->companyName,
//                     'var2' => $insurance->policyNumber,
//                     'data' => $insurance,
//                 ]),
//             ],
//             [
//                 'name' => 'General',
//                 'totalAssets' => $generalInsurance->map(fn($insurance) => [
//                     'var1' => $insurance->companyName,
//                     'var2' => $insurance->policyNumber,
//                     'data' => $insurance,
//                 ]),
//             ],
//             [
//                 'name' => 'Other',
//                 'totalAssets' => $otherInsurance->map(fn($insurance) => [
//                     'var1' => $insurance->companyName,
//                     'var2' => $insurance->policyNumber,
//                     'data' => $insurance,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Bullion',
//         'assets' => $bullion->map(fn($item) => [
//             'var1' => $item->metalType,
//             'var2' => $item->articleDetails,
//             'data' => $item,
//         ]),
//     ],
//     [
//         'assetName' => 'Business Assets',
//         'assets' => [
//             [
//                 'name' => 'Propritorship',
//                 'totalAssets' => $propritorship->map(fn($asset) => [
//                     'var1' => $asset->firmName,
//                     'var2' => $asset->registeredAddress,
//                     'data' => $asset,
//                 ]),
//             ],
//             [
//                 'name' => 'Partnership Firm',
//                 'totalAssets' => $partnershipFirm->map(fn($asset) => [
//                     'var1' => $asset->firmName,
//                     'var2' => $asset->registeredAddress,
//                     'data' => $asset,
//                 ]),
//             ],
//             [
//                 'name' => 'Company',
//                 'totalAssets' => $company->map(fn($asset) => [
//                     'var1' => $asset->companyName,
//                     'var2' => $asset->companyAddress,
//                     'data' => $asset,
//                 ]),
//             ],
//             [
//                 'name' => 'Intellectual Property',
//                 'totalAssets' => $intellectualProperty->map(fn($asset) => [
//                     'var1' => $asset->typeOfIp,
//                     'var2' => $asset->expiryDate,
//                     'data' => $asset,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Membership',
//         'assets' => $membership->map(fn($item) => [
//             'var1' => $item->organizationName,
//             'var2' => $item->membershipId,
//             'data' => $item,
//         ]),
//     ],
//     [
//         'assetName' => 'Other Assets',
//         'assets' => [
//             [
//                 'name' => 'Vehicles',
//                 'totalAssets' => $vehicle->map(fn($asset) => [
//                     'var1' => $asset->vehicleType,
//                     'var2' => $asset->company,
//                     'data' => $asset,
//                 ]),
//             ],
//             [
//                 'name' => 'Jewellery',
//                 'totalAssets' => $jewellery->map(fn($item) => [
//                     'var1' => $item->jewelleryType,
//                     'var2' => $item->weightPerJewellery,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Watches',
//                 'totalAssets' => $watch->map(fn($item) => [
//                     'var1' => $item->company,
//                     'var2' => $item->panNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'HUF',
//                 'totalAssets' => $huf->map(fn($item) => [
//                     'var1' => $item->hufName,
//                     'var2' => $item->panNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Recoverable',
//                 'totalAssets' => $recoverable->map(fn($item) => [
//                     'var1' => $item->nameOfBorrower,
//                     'var2' => $item->address,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Other Assets',
//                 'totalAssets' => $otherAsset->map(fn($item) => [
//                     'var1' => $item->nameOfAsset,
//                     'var2' => $item->assetDescription,
//                     'data' => $item,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Digital Assets',
//         'assets' => [
//             [
//                 'name' => 'Crypto',
//                 'totalAssets' => $crypto->map(fn($item) => [
//                     'var1' => $item->cryptoWalletType,
//                     'var2' => $item->cryptoWalletAddress,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Digital Assets',
//                 'totalAssets' => $digitalAsset->map(fn($item) => [
//                     'var1' => $item->digitalAsset,
//                     'var2' => $item->account,
//                     'data' => $item,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Loans',
//         'assets' => [
//             [
//                 'name' => 'Home Loan',
//                 'totalAssets' => $homeLoan->map(fn($loan) => [
//                     'var1' => $loan->bankName,
//                     'var2' => $loan->loanAccountNo,
//                     'data' => $loan,
//                 ]),
//             ],
//             [
//                 'name' => 'Personal Loan',
//                 'totalAssets' => $personalLoan->map(fn($loan) => [
//                     'var1' => $loan->bankName,
//                     'var2' => $loan->loanAccountNo,
//                     'data' => $loan,
//                 ]),
//             ],
//             [
//                 'name' => 'Vehicle Loan',
//                 'totalAssets' => $vehicleLoan->map(fn($loan) => [
//                     'var1' => $loan->bankName,
//                     'var2' => $loan->loanAccountNo,
//                     'data' => $loan,
//                 ]),
//             ],
//             [
//                 'name' => 'Other Loan',
//                 'totalAssets' => $otherLoan->map(fn($loan) => [
//                     'var1' => $loan->bankName,
//                     'var2' => $loan->loanAccountNo,
//                     'data' => $loan,
//                 ]),
//             ],
//             [
//                 'name' => 'Litigation',
//                 'totalAssets' => $litigation->map(fn($item) => [
//                     'var1' => $item->litigationType,
//                     'var2' => $item->courtName,
//                     'data' => $item,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Bank',
//         'assets' => [
//             [
//                 'name' => 'Bank Account',
//                 'totalAssets' => $bankAccount->map(fn($account) => [
//                     'var1' => $account->bankName,
//                     'var2' => $account->accountType,
//                     'data' => $account,
//                 ]),
//             ],
//             [
//                 'name' => 'Fix Deposit',
//                 'totalAssets' => $fixDeposite->map(fn($item) => [
//                     'var1' => $item->fixDepositeNumber,
//                     'var2' => $item->bankName,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Bank Locker',
//                 'totalAssets' => $bankLocker->map(fn($item) => [
//                     'var1' => $item->bankName,
//                     'var2' => $item->branch,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Postal Saving Account',
//                 'totalAssets' => $postalSavingAccount->map(fn($item) => [
//                     'var1' => $item->accountNumber,
//                     'var2' => $item->postOfficeBranch,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Post Saving Scheme',
//                 'totalAssets' => $postSavingScheme->map(fn($item) => [
//                     'var1' => $item->type,
//                     'var2' => $item->certificateNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Other Deposit',
//                 'totalAssets' => $otherDeposite->map(fn($item) => [
//                     'var1' => $item->fdNumber,
//                     'var2' => $item->company,
//                     'data' => $item,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Retirement Funds',
//         'assets' => [
//             [
//                 'name' => 'Public Provident Fund',
//                 'totalAssets' => $publicProvidentFund->map(fn($fund) => [
//                     'var1' => $fund->bankName,
//                     'var2' => $fund->ppfAccountNo,
//                     'data' => $fund,
//                 ]),
//             ],
//             [
//                 'name' => 'Provident Fund',
//                 'totalAssets' => $providentFund->map(fn($fund) => [
//                     'var1' => $fund->employerName,
//                     'var2' => $fund->uanNumber,
//                     'data' => $fund,
//                 ]),
//             ],
//             [
//                 'name' => 'NPS',
//                 'totalAssets' => $nps->map(fn($fund) => [
//                     'var1' => $fund->PRAN,
//                     'var2' => $fund->natureOfHolding,
//                     'data' => $fund,
//                 ]),
//             ],
//             [
//                 'name' => 'Gratuity',
//                 'totalAssets' => $gratuity->map(fn($fund) => [
//                     'var1' => $fund->employerName,
//                     'var2' => $fund->employerId,
//                     'data' => $fund,
//                 ]),
//             ],
//             [
//                 'name' => 'Super Annuation',
//                 'totalAssets' => $superAnnuation->map(fn($fund) => [
//                     'var1' => $fund->companyName,
//                     'var2' => $fund->masterPolicyNumber,
//                     'data' => $fund,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Real Estate',
//         'assets' => [
//             [
//                 'name' => 'Land',
//                 'totalAssets' => $land->map(fn($property) => [
//                     'var1' => $property->propertyType,
//                     'var2' => $property->surveyNumber,
//                     'data' => $property,
//                 ]),
//             ],
//             [
//                 'name' => 'Commercial Property',
//                 'totalAssets' => $commercialProperty->map(fn($property) => [
//                     'var1' => $property->propertyType,
//                     'var2' => $property->houseNumber,
//                     'data' => $property,
//                 ]),
//             ],
//             [
//                 'name' => 'Residential Property',
//                 'totalAssets' => $residentialProperty->map(fn($property) => [
//                     'var1' => $property->propertyType,
//                     'var2' => $property->houseNumber,
//                     'data' => $property,
//                 ]),
//             ],
//         ],
//     ],
//     [
//         'assetName' => 'Financial Assets',
//         'assets' => [
//             [
//                 'name' => 'Shares',
//                 'totalAssets' => $shareDetail->map(fn($item) => [
//                     'var1' => $item->companyName,
//                     'var2' => $item->folioNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Mutual Funds',
//                 'totalAssets' => $mutualFund->map(fn($item) => [
//                     'var1' => $item->fundName,
//                     'var2' => $item->folioNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Debentures',
//                 'totalAssets' => $debenture->map(fn($item) => [
//                     'var1' => $item->bankServiceProvider,
//                     'var2' => $item->companyName,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Bonds',
//                 'totalAssets' => $bond->map(fn($item) => [
//                     'var1' => $item->bankServiceProvider,
//                     'var2' => $item->companyName,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'ESOP',
//                 'totalAssets' => $esop->map(fn($item) => [
//                     'var1' => $item->companyName,
//                     'var2' => $item->unitsGranted,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Demat Account',
//                 'totalAssets' => $dematAccount->map(fn($item) => [
//                     'var1' => $item->depositoryName,
//                     'var2' => $item->depositoryId,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Wealth Management Account',
//                 'totalAssets' => $wealthManagementAccount->map(fn($item) => [
//                     'var1' => $item->wealthManagerName,
//                     'var2' => $item->accountNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Broking Account',
//                 'totalAssets' => $brokingAccount->map(fn($item) => [
//                     'var1' => $item->brokerName,
//                     'var2' => $item->brokingAccountNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Alternate Investment Fund',
//                 'totalAssets' => $alternateInvestmentFund->map(fn($item) => [
//                     'var1' => $item->fundName,
//                     'var2' => $item->folioNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Portfolio Management',
//                 'totalAssets' => $portfolioManagement->map(fn($item) => [
//                     'var1' => $item->fundName,
//                     'var2' => $item->folioNumber,
//                     'data' => $item,
//                 ]),
//             ],
//             [
//                 'name' => 'Other Financial Assets',
//                 'totalAssets' => $otherFinancialAsset->map(fn($item) => [
//                     'var1' => $item->bankServiceProvider,
//                     'var2' => $item->folioNumber,
//                     'data' => $item,
//                 ]),
//             ],
//         ],
//     ],
// ];

// // Return the data in JSON format
// return response()->json($data);
