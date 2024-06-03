<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeneficiaryController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['middleware'=>['auth.guest']], function(){

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

});



Route::group(['middleware'=>['auth:sanctum']], function(){


});

Route::post('/profile', [ProfileController::class, 'CreateProfile']);


Route::post('/beneficiary', [BeneficiaryController::class, 'CreateBeneficiary']);
Route::post('/Charity', [CharityController::class, 'CreateCharity']);

















