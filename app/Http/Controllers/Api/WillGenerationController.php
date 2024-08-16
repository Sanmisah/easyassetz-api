<?php

namespace App\Http\Controllers\Api;

use Log;
use File;
use Response;
use Mpdf\Mpdf;
use Barryvdh\DomPDF\PDF;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $profile = $user->profile;
        $asset = $profile->asset;
        
        $data = [
            'user' => $user,
            'profile' => $profile,
            'asset' => $asset,
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