<?php

namespace App\Http\Controllers\Api;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;

class PdfController extends BaseController
{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    // public function generatePDF(): JsonResponse
    // {
    //     $data = [
    //         'title' => 'Welcome to Laravel PDF generation',
    //         'content' => 'This is the content for the PDF file.',
    //     ];

    //     $pdf = new PDF(); // Instantiate PDF

    //     $pdf->loadView('pdf.test', $data); // Call loadView() on the instance

    //     return $pdf->download('test.pdf');
    // }

    // public function generatePDF(): JsonResponse
    // {
    //     $data = [
    //         'title' => 'Welcome to Laravel PDF generation',
    //         'content' => 'This is the content for the PDF file.',
    //     ];

    //     $this->pdf->loadView('pdf.test', $data); // Call loadView() on the instance

    //     return $this->pdf->download('test.pdf');
    // }

    public function generatePDF(): JsonResponse
    {
        $data = [
            'title' => 'Welcome to Laravel PDF generation',
            'content' => 'This is the content for the PDF file.',
        ];

        $this->pdf->loadView('pdf.test', $data); // Call loadView() on the instance

        $pdf = $this->pdf->output(); // Get the PDF content

        return response()->json(['message' => 'PDF generated successfully', 'pdf' => base64_encode($pdf)]);
    }

}


