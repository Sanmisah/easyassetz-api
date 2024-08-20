<?php

namespace App\Http\Controllers\Api;

use Log;
use File;
use Response;
use Mpdf\Mpdf;
use Barryvdh\DomPDF\PDF;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Models\MotorInsurance;
use App\Models\AssetAllocation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class WillGenerationController extends BaseController
{

    protected $will;

    public function __construct(PDF $will)
    {
        $this->will = $will;
    }



    public function generateWill()
{
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $profile = $user->profile;
    if (!$profile || !$profile->will) {
        return response()->json(['error' => 'Profile or will not found'], 404);
    }

    $willId = $profile->will->id;

    $assets = AssetAllocation::with('beneficiary', 'motorInsurance', 'lifeInsurance',
    'generalInsurance','otherInsurance','healthInsurance','bullion','membership',
    'vehicleLoan','homeLoan','personalLoan','otherLoan','litigation','crypto',
    'shareDetail','mutualFund','debenture','bond','dematAccount','wealthManagementAccount'
    ,'brokingAccount','investmentFund','portfolioManagement','otherFinancialAsset',
    'bankAccount','fixDeposite','otherAsset','bankLocker','postalSavingAccount',
    'postSavingScheme','otherDeposite','land','publicProvidentFund','providentFund',
    'nps','gratuity','residentialProperty','superAnnuation','commercialProperty',
    'digitalAsset','esop','vehicleLoan')
         ->where('will_id', $willId)
        ->orderBy('asset_type')
        ->orderBy('asset_id')
        ->orderBy('Level')
        ->get();

    $primaryAllocation = $secondaryAllocation = $tertiaryAllocation = collect();

    foreach ($assets as $asset) {
        if ($asset->asset_type === "motorInsurance") {
            if ($asset->level === 'Primary') {
                $primaryAllocation->push($asset);
            } elseif ($asset->level === 'Secondary') {
                $secondaryAllocation->push($asset);
            } elseif ($asset->level === 'Tertiary') {
                $tertiaryAllocation->push($asset);
            }
        }
    }

    $Data = [
        'primaryAllocation' => $primaryAllocation,
        'secondaryAllocation' => $secondaryAllocation,
        'tertiaryAllocation' => $tertiaryAllocation,
    ];

    $print = [
        'user' => $user,
        'profile' => $profile,
        'Assets' => $Data,
    ];

    // Render the Blade view to HTML
    $html = view('will.will', $print)->render();

    // Create a new mPDF instance
    $mpdf = new \Mpdf\Mpdf();

    // Write HTML to the PDF
    $mpdf->WriteHTML($html);

    // Define the file path for saving the PDF
    $filePath = 'public/will/will' . time() . '.pdf'; // Store in 'storage/app/invoices'

    // Save PDF to storage
    Storage::put($filePath, $mpdf->Output('', 'S')); // Output as string and save to storage

    // Output the PDF for download
    return $mpdf->Output('will.pdf', 'D'); // Download the PDF
    // return $Data;
}


    // public function generateWill()
    // {
    //    /*
    //         Find will_id
    //         Get will
    //         Get asset_allocations where will_id = will_id
    //         Order by asset_type, asset_id, level
    //         asset_allocation belongsTo Asset
    //         asset_allocation belongsTo Beneficiry
    //     */
    //     $user = auth()->user();
    //     $profile = $user->profile;
    //     $assets = AssetAllocation::where('will_id', auth()->user()->profile->will->id)
    //     ->OrderBy('asset_type')
    //     ->OrderBy('asset_id')
    //     ->OrderBy('Level')
    //     ->get();

    //     $Data = [];

    //     foreach ($assets as $asset) {
    //             if($asset->asset_type === "motorInsurance"){

    //                  $primaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
    //                  ->where('level', 'Primary')
    //                  ->where('will_id', auth()->user()->profile->will->id)
    //                  ->where('asset_type', 'motorInsurance')
    //                  ->get();
                 
    //                     $secondaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
    //                     ->where('level', 'Secondary')
    //                     ->where('will_id', auth()->user()->profile->will->id)
    //                     ->where('asset_type', 'motorInsurance')
    //                     ->get();
                      
    //                     $tertiaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
    //                     ->where('level', 'Tertiary')
    //                     ->where('will_id', auth()->user()->profile->will->id)
    //                     ->where('asset_type', 'motorInsurance')
    //                     ->get();
    //                    }
    //             }   

    //             $Data[] = [
    //                 'primaryAllocation' => $primaryAllocation,
    //                 'secondaryAllocation' => $secondaryAllocation,
    //                 'tertiaryAllocation' => $tertiaryAllocation,
    //             ];
      
    //     $print = [
    //         'user' => $user,
    //         'profile' => $profile,
    //         'Assets' => $Data,
    //     ];

    //     // Render the Blade view to HTML
    //     $html = view('will.will', $print)->render();

    //     // Create a new mPDF instance
    //     $mpdf = new Mpdf();

    //     // Write HTML to the PDF
    //     $mpdf->WriteHTML($html);

    //     // Define the file path for saving the PDF
    //     $filePath = 'public/will/will' . time() . '.pdf'; // Store in 'storage/app/invoices'

    //     // Save PDF to storage
    //     Storage::put($filePath, $mpdf->Output('', 'S')); // Output as string and save to storage

    //     // Output the PDF for download
    //     return $mpdf->Output('will.pdf', 'D'); // Download the PDF
    // }





























    
    
//     public function generateWill()
//     {
//         /*
//             Find will_id
//             Get will
//             Get asset_allocations where will_id = will_id
//             Order by asset_type, asset_id, level
//             asset_allocation belongsTo Asset
//             asset_allocation belongsTo Beneficiry
//         */
//         $user = auth()->user();
//         $profile = $user->profile;
 
        
//         $motorInsuranceData = [];
//         $asset_type = [
//             'motorInsurance',
//             'membership',
//             "bullion",
//             "healthInsurance",
//             "lifeInsurance",
//             "generalInsurance",
//             "otherInsurance",
//             "propritorship",
//             "partnershipFirm",
//             "company",
//             "intellectualProperty",
//             "land",
//             "commercialProperty",
//             "residentialProperty",
//             "shareDetail",
//             "mutualFund",
//             "debenture",
//             "bond",
//             "esop",
//             "dematAccount",
//             "wealthManagementAccount",
//             "brokingAccount",
//             "alternateInvestmentFund",
//             "portfolioManagement",
//             "otherFinancialAsset",
//             "crypto",
//             "digitalAsset",
//             "vehicle",
//             "jewellery",
//             "watch",
//             "huf",
//             "recoverable",
//             "otherAsset",
//             "bankAccount",
//             "fixDeposite",
//             "bankLocker",
//             "postalSavingAccount",
//             "postSavingScheme",
//             "otherDeposite",
//             "publicProvidentFund",
//             "providentFund",
//             "nps",
//             "gratuity",
//              "vehicleLoan",
//             "homeLoan",
//             "personalLoan",
//             "litigation",
            
//             "superAnnuation",
//            ];
//            $assetAll = [];
//            $user = auth()->user();
//     $profile = $user->profile;

//     // Define asset types
//     $asset_type = [
//         'motorInsurance',
//         'membership',
//     ];

//     $assetAll = [];
//     foreach ($asset_type as $assetType) {
//         $assets = AssetAllocation::where('will_id', $profile->will->id)
//             ->where('asset_type', $assetType)
//             ->orderBy('asset_type')
//             ->orderBy('asset_id')
//             ->orderBy('level')
//             ->get();
        
//         $assets->load('beneficiary', $assetType);
//         $assetAll = array_merge($assetAll, $assets->toArray());
//     }

//     // Function to get the unique allocation by asset_id
//     function getAssetAllocation($assets, $assetTypes) {
//         $uniqueCheck = [];
//         $allocation = [];

//         foreach ($assets as $asset) {
//             if (in_array($asset['asset_type'], $assetTypes) && !in_array($asset['asset_id'], $uniqueCheck)) {
//                 $uniqueCheck[] = $asset['asset_id'];

//                 $primaryAllocation = array_filter($assets, function($item) use ($asset) {
//                     return $item['asset_id'] === $asset['asset_id'] && $item['level'] === 'Primary';
//                 });

//                 $secondaryAllocation = array_filter($assets, function($item) use ($asset) {
//                     return $item['asset_id'] === $asset['asset_id'] && $item['level'] === 'Secondary';
//                 });

//                 $tertiaryAllocation = array_filter($assets, function($item) use ($asset) {
//                     return $item['asset_id'] === $asset['asset_id'] && $item['level'] === 'Tertiary';
//                 });

//                 $allocation[$asset['asset_type']][] = [
//                     'asset_id' => $asset['asset_id'],
//                     'primaryAllocation' => $primaryAllocation,
//                     'secondaryAllocation' => $secondaryAllocation,
//                     'tertiaryAllocation' => $tertiaryAllocation,
//                 ];
//             }
//         }

//         return $allocation;
//     }

//     $allocation = getAssetAllocation($assetAll, $asset_type);

 
//         $data = [
//             'user' => $user,
//             'profile' => $profile,
//             'assets' => $assets,
//             // 'motorInsuranceData' => $motorInsuranceData,
//         ];

//         // Render the Blade view to HTML
//         // $html = view('will.will', $data)->render();

//         // // Create a new mPDF instance
//         // $mpdf = new Mpdf();

//         // // Write HTML to the PDF
//         // $mpdf->WriteHTML($html);

//         // // Define the file path for saving the PDF
//         // $filePath = 'public/will/will' . time() . '.pdf'; // Store in 'storage/app/invoices'

//         // // Save PDF to storage
//         // Storage::put($filePath, $mpdf->Output('', 'S')); // Output as string and save to storage

//         // Output the PDF for download
//         // return $mpdf->Output('will.pdf', 'D'); // Download the PDF
//         return $allocation;
//     }
}







































































  // foreach ($assets as $asset) {
        //     if($asset->asset_type === "motorInsurance"){
        //         // dd($asset->asset_id);
        //         $motorInsurance = MotorInsurance::find($asset->asset_id)->with('nominee')->get();
        //         $assetData = $asset;
        //     }
        // }

        // foreach ($assets as $asset) {
        //     if($asset->asset_type === "motorInsurance"){
        //          $motorInsurance = AssetAllocation::with('beneficiary', 'motorInsurance')
        //          ->where('level', 'Primary')
        //          ->with('secondaryBeneficiary')
        //          ->where('level', 'Secondary')
        //          ->where('will_id', auth()->user()->profile->will->id)
        //          ->where('asset_type', 'motorInsurance')
        //          ->get();
                 
        //         }
        // }