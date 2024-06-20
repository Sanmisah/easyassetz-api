<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BullionController;
use App\Http\Controllers\Api\CharityController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\BeneficiaryController;
use App\Http\Controllers\Api\VehicleLoanController;
use App\Http\Controllers\Api\LifeInsuranceController;
use App\Http\Controllers\Api\MotorInsuranceController;
use App\Http\Controllers\Api\OtherInsuranceController;
use App\Http\Controllers\Api\GeneralInsuranceController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['middleware'=>['auth.guest']], function(){
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::resource('profiles', ProfileController::class);
    Route::resource('beneficiaries', BeneficiaryController::class);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::resource('motor-insurances', MotorInsuranceController::class);
    Route::resource('life-insurances', LifeInsuranceController::class);
    Route::resource('other-insurances', OtherInsuranceController::class);
    Route::resource('general-insurances', GeneralInsuranceController::class);
    Route::resource('bullions', BullionController::class);
    Route::resource('memberships', MembershipController::class);
    Route::resource('vehicle-loans', VehicleLoanController::class);


});