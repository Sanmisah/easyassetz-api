<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MotorInsurance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\MotorInsuranceResource;
use App\Http\Requests\StoreMotorInsuranceRequest;
use App\Http\Requests\UpdateMotorInsuranceRequest;

class MotorInsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $motorInsurance = $user->profile->motorInsurance()->with('nominee')->get();
        if(!$motorInsurance){
            return $this->sendError('Motor Insurance not added',['error'=>'motor insurances not added yet']);
        }
        return $this->sendResponse(['MotorInsurances'=>MotorInsuranceResource::collection($motorInsurance)], "Motor Insurances retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMotorInsuranceRequest $request): JsonResponse
    {

        if($request->hasFile('image')){
            $motorFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $motorFilename = pathinfo($motorFileNameWithExtention, PATHINFO_FILENAME);
            $motorExtention = $request->file('image')->getClientOriginalExtension();
            $motorFileNameToStore = $motorFilename.'_'.time().'.'.$motorExtention;
            $motorPath = $request->file('image')->storeAs('public/MotorInsurance', $motorFileNameToStore);
         }

        $user = Auth::user();
        $motorInsurance = new MotorInsurance();
        $motorInsurance->profile_id = $user->profile->id;
        $motorInsurance->company_name = $request->input('companyName');
        $motorInsurance->insurance_sub_type = $request->input('insuranceType');
        $motorInsurance->policy_number = $request->input('policyNumber');
        $motorInsurance->expiry_date = $request->input('expiryDate');
        $motorInsurance->premium = $request->input('premium');
        $motorInsurance->sum_insured = $request->input('sumInsured');
        $motorInsurance->insurer_name = $request->input('insurerName');
        $motorInsurance->vehicle_type = $request->input('vehicleType');
        $motorInsurance->mode_of_purchase = $request->input('modeOfPurchase');
        $motorInsurance->broker_name = $request->input('brokerName');
        $motorInsurance->contact_person = $request->input('contactPerson');
        $motorInsurance->contact_number = $request->input('contactNumber');
        $motorInsurance->email = $request->input('email');
        $motorInsurance->registered_mobile = $request->input('registeredMobile');
        $motorInsurance->registered_email = $request->input('registeredEmail');
        if($request->hasFile('image')){
            $motorInsurance->image = $motorFileNameToStore;
         }
        $motorInsurance->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $motorInsurance->nominee()->attach($nominee_id);
        }
        
        return $this->sendResponse(['MotorInsurance'=>new MotorInsuranceResource($motorInsurance)], 'Motor Insurance Data Stored successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motorInsurance = MotorInsurance::find($id);
        if(!$motorInsurance){
            return $this->sendError('motorInsurance Not Found',['error'=>'motorInsurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $motorInsurance->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Motor Insurance']);
         }
         $motorInsurance->load('nominee');

        return $this->sendResponse(['MotorInsurance'=>new MotorInsuranceResource($motorInsurance)], 'Motor Insurance retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotorInsuranceRequest $request, string $id)
    {
        if($request->hasFile('image')){
            $motorFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $motorFilename = pathinfo($motorFileNameWithExtention, PATHINFO_FILENAME);
            $motorExtention = $request->file('image')->getClientOriginalExtension();
            $motorFileNameToStore = $motorFilename.'_'.time().'.'.$motorExtention;
            $motorPath = $request->file('image')->storeAs('public/MotorInsurance', $motorFileNameToStore);
         }


        $motorInsurance = MotorInsurance::find($id);
        if(!$motorInsurance){
            return $this->sendError('motorInsurance Not Found', ['error'=>'Motor Insurance not found']);
        }

         $user = Auth::user();
         if($user->profile->id !== $motorInsurance->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Motor Insurance']);
         }

         $motorInsurance->company_name = $request->input('companyName');
         $motorInsurance->insurance_sub_type = $request->input('insuranceType');
         $motorInsurance->policy_number = $request->input('policyNumber');
         $motorInsurance->expiry_date = $request->input('expiryDate');
         $motorInsurance->premium = $request->input('premium');
         $motorInsurance->sum_insured = $request->input('sumInsured');
         $motorInsurance->insurer_name = $request->input('insurerName');
         $motorInsurance->vehicle_type = $request->input('vehicleType');
         $motorInsurance->mode_of_purchase = $request->input('modeOfPurchase');
         $motorInsurance->broker_name = $request->input('brokerName');
         $motorInsurance->contact_person = $request->input('contactPerson');
         $motorInsurance->contact_number = $request->input('contactNumber');
         $motorInsurance->email = $request->input('email');
         $motorInsurance->registered_mobile = $request->input('registeredMobile');
         $motorInsurance->registered_email = $request->input('registeredEmail');
         if($request->hasFile('image')){
            $motorInsurance->image = $motorFileNameToStore;
         }
         $motorInsurance->save();
 
        //  if($request->has('nomineeId')){
        //      $nominee_id = $request->input('nomineeId');
        //      $motorInsurance->nominee()->attach($nominee_id);
        //  }

        if ($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $motorInsurance->nominee()->sync($nominee_ids);
        } else {
            // If no nominees selected, detach all existing nominees
            $motorInsurance->nominee()->detach();
        }
         
         return $this->sendResponse(['MotorInsurance'=>new MotorInsuranceResource($motorInsurance)], 'Motor Insurance Data updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $motorInsurance = MotorInsurance::find($id);
        if(!$motorInsurance){
            return $this->sendError('Motor Insurance not found', ['error'=>'Motor Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $motorInsurance->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Motor Insurance']);
        }

        if (!empty($motorInsurance->image) && Storage::exists('public/MotorInsurance/' . $motorInsurance->image)) {
            Storage::delete('public/MotorInsurance/' . $motorInsurance->image);
        }

        $motorInsurance->delete();

        return $this->sendResponse([], 'Motor Insurance deleted successfully');
    }
}
