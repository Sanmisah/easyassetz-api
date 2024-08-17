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
        $assets = AssetAllocation::where('will_id', auth()->user()->profile->will->id)
        ->OrderBy('asset_type')
        ->OrderBy('asset_id')
        ->OrderBy('Level')
        ->get();

        $motorInsuranceData = [];

        foreach ($assets as $asset) {
                if($asset->asset_type === "motorInsurance"){

                    $mdata = 
                     $primaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
                     ->where('level', 'Primary')
                     ->where('will_id', auth()->user()->profile->will->id)
                     ->where('asset_type', 'motorInsurance')
                     ->get();
                 
                        $secondaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
                        ->where('level', 'Secondary')
                        ->where('will_id', auth()->user()->profile->will->id)
                        ->where('asset_type', 'motorInsurance')
                        ->get();
                      
                        $tertiaryAllocation = AssetAllocation::with('beneficiary', 'motorInsurance')
                        ->where('level', 'Tertiary')
                        ->where('will_id', auth()->user()->profile->will->id)
                        ->where('asset_type', 'motorInsurance')
                        ->get();
                       }
                }   

                $motorInsuranceData[] = [
                    'primaryAllocation' => $primaryAllocation,
                    'secondaryAllocation' => $secondaryAllocation,
                    'tertiaryAllocation' => $tertiaryAllocation,
                ];
      
        $data = [
            'user' => $user,
            'profile' => $profile,
            'assets' => $assets,
            'motorInsuranceData' => $motorInsuranceData,
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
        return $mpdf->Output('will.pdf', 'D'); // Download the PDF
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