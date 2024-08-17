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
        /*
            Find will_id
            Get will
            Get asset_allocations where will_id = will_id
            Order by asset_type, asset_id, level
            asset_allocation belongsTo Asset
            asset_allocation belongsTo Beneficiry
        */
        $user = auth()->user();
        $profile = $user->profile;
 
        
        $motorInsuranceData = [];
        $asset_type = [
            'motorInsurance',
            'membership',
            // "bullion",
            // "healthInsurance",
            // "lifeInsurance",
            // "generalInsurance",
            // "otherInsurance",
            // "propritorship",
            // "partnershipFirm",
            // "company",
            // "intellectualProperty",
            // "land",
            // "commercialProperty",
            // "residentialProperty",
            // "shareDetail",
            // "mutualFund",
            // "debenture",
            // "bond",
            // "esop",
            // "dematAccount",
            // "wealthManagementAccount",
            // "brokingAccount",
            // "alternateInvestmentFund",
            // "portfolioManagement",
            // "otherFinancialAsset",
            // "crypto",
            // "digitalAsset",
            // "vehicle",
            // "jewellery",
            // "watch",
            // "huf",
            // "recoverable",
            // "otherAsset",
            // "bankAccount",
            // "fixDeposite",
            // "bankLocker",
            // "postalSavingAccount",
            // "postSavingScheme",
            // "otherDeposite",
            // "publicProvidentFund",
            // "providentFund",
            // "nps",
            // "gratuity",
            //  "vehicleLoan",
            // "homeLoan",
            // "personalLoan",
            // "litigation",
            
            // "superAnnuation",
           ];
           $assetAll = [];
           foreach ($asset_type as $assetType) {
             $assets = AssetAllocation::
            where('will_id', auth()->user()->profile->will->id)
            ->where('asset_type', $assetType) // Filter by asset_type
           ->OrderBy('asset_type')
           ->OrderBy('asset_id')
           ->OrderBy('Level')
            
            ->get();
            $assets->load('beneficiary',$assetType );
            $assetAll[] = $assets->toArray();
           }


           $allocation = [];  
        function getAssetAllocation($assets, $assetTypes) {
        
            foreach ($assetTypes as $asset) {
            foreach ($assets as $assetType) {
                // Filter the assets collection by asset type
                  $filteredAssets = array_filter($assetType, function ($assete) use ($assetTypes) {
                     return $assete['asset_type'] === $assetTypes;
                });
                       // Fetch primary, secondary, and tertiary allocations
                     $primaryAllocation = $filteredAssets->where('level', 'Primary')->values()->all();
                    $secondaryAllocation = $filteredAssets->where('level', 'Secondary')->values()->all();
                    $tertiaryAllocation = $filteredAssets->where('level', 'Tertiary')->values()->all();
                
                    // Add allocations to the array
                    $allocation[] = [
                        'primaryAllocation' => $primaryAllocation,
                        'secondaryAllocation' => $secondaryAllocation,
                        'tertiaryAllocation' => $tertiaryAllocation,
                    ];
                
                    $filteredAllocation = array_filter($allocation, function($item) {
                        return !empty($item['primaryAllocation']) || !empty($item['secondaryAllocation']) || !empty($item['tertiaryAllocation']);
                    });
            }
        
        }
        
            return $filteredAllocation;
 
         }
        
             $allocation = getAssetAllocation($assetAll, $asset_type);
    
             

        $data = [
            'user' => $user,
            'profile' => $profile,
            'assets' => $assets,
            // 'motorInsuranceData' => $motorInsuranceData,
        ];

        // Render the Blade view to HTML
        $html = view('will.will', $data)->render();

        // Create a new mPDF instance
        $mpdf = new Mpdf();

        // Write HTML to the PDF
        $mpdf->WriteHTML($html);

        // Define the file path for saving the PDF
        $filePath = 'public/will/will' . time() . '.pdf'; // Store in 'storage/app/invoices'

        // Save PDF to storage
        Storage::put($filePath, $mpdf->Output('', 'S')); // Output as string and save to storage

        // Output the PDF for download
        // return $mpdf->Output('will.pdf', 'D'); // Download the PDF
        return $allocation;
    }
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