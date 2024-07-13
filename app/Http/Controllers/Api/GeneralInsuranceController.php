<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GeneralInsurance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\GeneralInsuranceResource;
use App\Http\Requests\StoreGeneralInsuranceRequest;
use App\Http\Requests\UpdateGeneralInsuranceRequest;

class GeneralInsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
         $user = Auth::user();
         $generalInsurance = $user->profile->generalInsurance()->with('nominee')->get();
         return $this->sendResponse(['GeneralInsurance'=>GeneralInsuranceResource::collection($generalInsurance)],'General insurance retrived successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralInsuranceRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $generalFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $generalFilename = pathinfo($generalFileNameWithExtention, PATHINFO_FILENAME);
            $generalExtention = $request->file('image')->getClientOriginalExtension();
            $generalFileNameToStore = $generalFilename.'_'.time().'.'.$generalExtention;
            $generalPath = $request->file('image')->storeAs('public/GeneralInsurance', $generalFileNameToStore);
         }

        $user = Auth::user();
        $generalInsurance = new GeneralInsurance();
        $generalInsurance->profile_id = $user->profile->id;
        $generalInsurance->company_name = $request->input('companyName');
        $generalInsurance->insurance_type = $request->input('insuranceType');
        $generalInsurance->policy_number = $request->input('policyNumber');
        $generalInsurance->maturity_date = $request->input('maturityDate');
        $generalInsurance->premium = $request->input('premium');
        $generalInsurance->sum_insured = $request->input('sumInsured');
        $generalInsurance->policy_holder_name = $request->input('policyHolderName');
        $generalInsurance->additional_details = $request->input('additionalDetails');
        $generalInsurance->mode_of_purchase = $request->input('modeOfPurchase');
        $generalInsurance->broker_name = $request->input('brokerName');
        $generalInsurance->contact_person = $request->input('contactPerson');
        $generalInsurance->contact_number = $request->input('contactNumber');
        $generalInsurance->email = $request->input('email');
        $generalInsurance->registered_mobile = $request->input('registeredMobile');
        $generalInsurance->registered_email = $request->input('registeredEmail');
        if($request->hasFile('image')){
            $generalInsurance->image = $generalFileNameToStore;
         }
        $generalInsurance->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $generalInsurance->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['GeneralInsurance'=> new GeneralInsuranceResource($generalInsurance)],'General insurance details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = Auth::user();
        $generalInsurance = GeneralInsurance::find($id);
        if(!$generalInsurance){
            return $this->sendError('General Insurance not found', ['error'=>'general insurance not found']);
        } 

        if($user->profile->id !== $generalInsurance->profile_id){
            return $this->sendError('Unauthorize', ['error'=>'you are not allowed to access view this general insurance']);
        }
        $generalInsurance->load('nominee');

        return $this->sendResponse(['GeneralInsurance'=> new GeneralInsuranceResource($generalInsurance)], 'General Insurance retrived successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralInsuranceRequest $request, string $id): JsonResponse
    {

        if($request->hasFile('image')){
            $generalFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $generalFilename = pathinfo($generalFileNameWithExtention, PATHINFO_FILENAME);
            $generalExtention = $request->file('image')->getClientOriginalExtension();
            $generalFileNameToStore = $generalFilename.'_'.time().'.'.$generalExtention;
            $generalPath = $request->file('image')->storeAs('public/GeneralInsurance', $generalFileNameToStore);
         }


        $generalInsurance = GeneralInsurance::find($id);
        if(!$generalInsurance){
            return $this->sendError('General Insurance Not Found',['error'=>'General Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $generalInsurance->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this General Insurance']);
         }

         $generalInsurance->company_name = $request->input('companyName');
         $generalInsurance->insurance_type = $request->input('insuranceType');
         $generalInsurance->policy_number = $request->input('policyNumber');
         $generalInsurance->maturity_date = $request->input('maturityDate');
         $generalInsurance->premium = $request->input('premium');
         $generalInsurance->sum_insured = $request->input('sumInsured');
         $generalInsurance->policy_holder_name = $request->input('policyHolderName');
         $generalInsurance->additional_details = $request->input('additionalDetails');
         $generalInsurance->mode_of_purchase = $request->input('modeOfPurchase');
         $generalInsurance->broker_name = $request->input('brokerName');
         $generalInsurance->contact_person = $request->input('contactPerson');
         $generalInsurance->contact_number = $request->input('contactNumber');
         $generalInsurance->email = $request->input('email');
         $generalInsurance->registered_mobile = $request->input('registeredMobile');
         $generalInsurance->registered_email = $request->input('registeredEmail');
         if($request->hasFile('image')){
            $generalInsurance->image = $generalFileNameToStore;
         }
         $generalInsurance->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $generalInsurance->nominee()->sync($nominee_ids);
        }else {
            $generalInsurance->nominee()->detach();
        }

        return $this->sendResponse(['GeneralInsurance'=> new GeneralInsuranceResource($generalInsurance)], 'General Insurance Updated successfully');
    }
            
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $generalInsurance = GeneralInsurance::find($id);
        if(!$generalInsurance){
            return $this->sendError('General Insurance not found', ['error'=>'General Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $generalInsurance->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this General Insurance']);
        }
        Storage::delete('public/GeneralInsurance/'.$generalInsurance->image);
        $generalInsurance->delete();

        return $this->sendResponse([], 'General Insurance deleted successfully');
    }
}
