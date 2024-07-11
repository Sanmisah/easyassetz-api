<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/symlink', function () {
  $target =$_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
  $link = $_SERVER['DOCUMENT_ROOT'].'/files';
  symlink($target, $link);
  echo "Done";  
});


Route::get('{any}', function () {
    // return view('app');
  //  return file_get_contents(public_path('index.html'));
   return file_get_contents('index.html');

})->where('any', '.*');
