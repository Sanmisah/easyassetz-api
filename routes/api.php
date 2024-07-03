<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BondController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CryptoController;
use App\Http\Controllers\Api\BullionController;
use App\Http\Controllers\Api\CharityController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\HomeLoanController;
use App\Http\Controllers\Api\DebentureController;
use App\Http\Controllers\Api\OtherLoanController;
use App\Http\Controllers\Api\LitigationController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\MutualFundController;
use App\Http\Controllers\Api\OtherAssetController;
use App\Http\Controllers\Api\BeneficiaryController;
use App\Http\Controllers\Api\VehicleLoanController;
use App\Http\Controllers\Api\PersonalLoanController;
use App\Http\Controllers\Api\BusinessAssetController;
use App\Http\Controllers\Api\LifeInsuranceController;
use App\Http\Controllers\Api\MotorInsuranceController;
use App\Http\Controllers\Api\OtherInsuranceController;
use App\Http\Controllers\Api\HealthInsuranceController;
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
    Route::resource('health-insurances', HealthInsuranceController::class);
    Route::resource('bullions', BullionController::class);
    Route::resource('memberships', MembershipController::class);
    Route::resource('vehicle-loans', VehicleLoanController::class);
    Route::resource('mutual-funds', MutualFundController::class);
    Route::resource('debentures', DebentureController::class);
    Route::resource('home-loans', HomeLoanController::class);
    Route::resource('personal-loans', PersonalLoanController::class);
    Route::resource('other-loans', OtherLoanController::class);
    Route::resource('litigations', LitigationController::class);
    Route::resource('cryptos', CryptoController::class);
    Route::resource('bonds', BondController::class);
    Route::resource('business-assets', BusinessAssetController::class);
    Route::delete('/logout', [UserController::class, 'logout']);
    Route::resource('other-assets', OtherAssetController::class);

});