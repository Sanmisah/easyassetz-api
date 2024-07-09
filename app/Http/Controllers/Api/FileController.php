<?php

namespace App\Http\Controllers\Api;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    // public function showFiles(string $files){
    //      $path = storage_path('app/public/'.$path)

    //      if(!file_exists($path)){
    //         abort(404);
    //      }

    //      $file = File::get($path);
    //      $type = \File::mimeType($path);

    //      $response = \Response::make($file, 200);
    //      $response->header("Content-Type", $type);

    // }
}
