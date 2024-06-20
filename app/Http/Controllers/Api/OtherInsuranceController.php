<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OtherInsurance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\OtherInsuranceResource;

class OtherInsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $otherInsurance = $user->profile->otherInsurance()->with('nominee')->get();
    
        return $this->sendResponse(['OtherInsurance'=>OtherInsuranceResource::collection($otherInsurance)], "Other Insurances retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $otherInsurance = new OtherInsurance();
        $otherInsurance->profile_id = $user->profile->id;
        $otherInsurance->company_name = $request->input('companyName');
        $otherInsurance->insurance_type = $request->input('insuranceType');
        $otherInsurance->policy_number = $request->input('policyNumber');
        $formatedDate = $request->input('maturityDate');
        $carbonDate = Carbon::parse($formatedDate);
        $iso8601Date = $carbonDate->toIso8601String();
        $otherInsurance->maturity_date = $iso8601Date;
        $otherInsurance->premium = $request->input('premium');
        $otherInsurance->sum_insured = $request->input('sumInsured');
        $otherInsurance->policy_holder_name = $request->input('policyHolderName');
        $otherInsurance->additional_details = $request->input('additionalDetails');
        $otherInsurance->mode_of_purchase = $request->input('modeOfPurchase');
        $otherInsurance->broker_name = $request->input('brokerName');
        $otherInsurance->contact_person = $request->input('contactPerson');
        $otherInsurance->contact_number = $request->input('contactNumber');
        $otherInsurance->email = $request->input('email');
        $otherInsurance->registered_mobile = $request->input('registeredMobile');
        $otherInsurance->registered_email = $request->input('registeredEmail');
        $otherInsurance->image = $request->input('image');
        $otherInsurance->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $otherInsurance->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['OtherInsurance'=> new OtherInsuranceResource($otherInsurance)], 'other Insurance details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $otherInsurance = OtherInsurance::find($id);
        if(!$otherInsurance){
            return $this->sendError('Other Insurance Not Found',['error'=>'Other Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherInsurance->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Insurance']);
         }
         $otherInsurance->load('nominee');

        return $this->sendResponse(['OtherInsurance'=>new OtherInsuranceResource($otherInsurance)], 'Other Insurance retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $otherInsurance = OtherInsurance::find($id);
        if(!$otherInsurance){
            return $this->sendError('Other Insurance Not Found',['error'=>'Other Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherInsurance->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Insurance']);
         }

         $otherInsurance = $request->input('companyName');
         $otherInsurance->insurance_type = $request->input('insuranceType');
         $otherInsurance->policy_number = $request->input('policyNumber');
         $formatedDate = $request->input('maturityDate');
         $carbonDate = Carbon::parse($formatedDate);
         $iso8601Date = $carbonDate->toIso8601String();
         $lifeInsurance->maturity_date = $iso8601Date;
         $otherInsurance->premium = $request->input('premium');
         $otherInsurance->sum_insured = $request->input('sumInsured');
         $otherInsurance->policy_holder_name = $request->input('policyHolderName');
         $otherInsurance->additional_details = $request->input('additionalDetails');
         $otherInsurance->mode_of_purchase = $request->input('modeOfPurchase');
         $otherInsurance->broker_name = $request->input('brokerName');
         $otherInsurance->contact_person = $request->input('contactPerson');
         $otherInsurance->contact_number = $request->input('contactNumber');
         $otherInsurance->email = $request->input('email');
         $otherInsurance->registered_mobile = $request->input('registeredMobile');
         $otherInsurance->registered_email = $request->input('registeredEmail');
         $otherInsurance->image = $request->input('image');
         $otherInsurance->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $otherInsurance->nominee()->sync($nominee_ids);
        }else {
            // If no nominees selected, detach all existing nominees
            $otherInsurance->nominee()->detach();
        }
  
          return $this->sendResponse(['OtherInsurance'=> new OtherInsuranceResource($otherInsurance)], 'Other Insurance details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $otherInsurance = OtherInsurance::find($id);
        if(!$otherInsurance){
            return $this->sendError('Other Insurance not found', ['error'=>'Other Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherInsurance->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Other Insurance']);
        }
        $otherInsurance->delete();

        return $this->sendResponse([], 'Other Insurance deleted successfully');
    }
}
