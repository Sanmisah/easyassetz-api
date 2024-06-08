<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MotorInsurance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\MotorInsuranceResource;

class MotorInsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $MotorInsurance = MotorInsurance::where('type','beneficiary')->where('profile_id',$user->profile->id)->get();
        
        if (!$beneficiary) {
             $beneficiary =null;
        }

        if (!$charity) {
            $charity = null;
        }
        return $this->sendResponse(['Beneficiaries'=>BeneficiaryResource::collection($beneficiary), 'Charities'=>BeneficiaryResource::collection($charity)], "Beneficiaries retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $MotorInsurance = new MotorInsurance();
        $MotorInsurance->profile_id = $user->profile->id;
        $MotorInsurance->company_name = $request->input('companyName');
        $MotorInsurance->insurance_sub_type = $request->input('insuranceSubType');
        $MotorInsurance->policy_number = $request->input('policyNumber');
        $formatedDate = $request->input('expiryDate');
        $carbonDate = Carbon::parse($formatedDate);
        $iso8601Date = $carbonDate->toIso8601String();
        $MotorInsurance->expiry_date = $iso8601Date;
        $MotorInsurance->premium = $request->input('premium');
        $MotorInsurance->sum_insured = $request->input('sumInsured');
        $MotorInsurance->insurer_name = $request->input('insurerName');
        $MotorInsurance->vehicle_type = $request->input('vehicleType');
        $MotorInsurance->mode_of_purchase = $request->input('modeOfPurchase');
        $MotorInsurance->broker_name = $request->input('brokerName');
        $MotorInsurance->contact_person = $request->input('contactPerson');
        $MotorInsurance->contact_number = $request->input('contactNumber');
        $MotorInsurance->email = $request->input('email');
        $MotorInsurance->nominee = $request->input('nominee');
        $MotorInsurance->registered_mobile = $request->input('registeredMobile');
        $MotorInsurance->registered_email = $request->input('registeredEmail');

        $MotorInsurance->save();

        return $this->sendResponse(['MotorInsurance'=>new MotorInsuranceResource($MotorInsurance)], 'Motor Insurance Data Stored successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
