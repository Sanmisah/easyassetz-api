<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BusinessAsset;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BusinessAssetsResource;
use App\Http\Requests\StoreBusinessAssetRequest;
use App\Http\Requests\UpdateBusinessAssetRequest;

class BusinessAssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $propritership = $user->profile->businessAsset()->where('type', 'propritorship')->with('nominee')->get();
        $partnershipFirm = $user->profile->businessAsset()->where('type', 'partnershipFirm')->with('nominee')->get();
        $company = $user->profile->businessAsset()->where('type', 'company')->with('nominee')->get();
        $intellectualProperty = $user->profile->businessAsset()->where('type', 'intellectualProperty')->with('nominee')->get();

        if(!$propritership){
            $propritership =null;
        }
        if(!$partnershipFirm){
         $partnershipFirm =null;
         }
        if(!$company){
          $company =null;
         }
        if(!$intellectualProperty){
          $intellectualProperty=null;
          }
       return $this->sendResponse(['Propritership'=>BusinessAssetsResource::collection($propritership),'PartnershipFirm'=>BusinessAssetsResource::collection($partnershipFirm),'Company'=>BusinessAssetsResource::collection($company),'IntellectualProperty'=>BusinessAssetsResource::collection($intellectualProperty)], "Business Assets retrived successfully");
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessAssetRequest $request): JsonResponse
    {
        if($request->hasFile('shareCentificateFile')){
            $shareFileNameWithExtention = $request->file('shareCentificateFile')->getClientOriginalName();
            $shareFilename = pathinfo($shareFileNameWithExtention, PATHINFO_FILENAME);
            $shareExtention = $request->file('shareCentificateFile')->getClientOriginalExtension();
            $shareFileNameToStore = $shareFilename.'_'.time().'.'.$shareExtention;
            $sharePath = $request->file('shareCentificateFile')->storeAs('public/BusinessAsset/shareCentificateFile', $shareFileNameToStore);
         }

         if($request->hasFile('partnershipDeedFile')){
            $partFileNameWithExtention = $request->file('partnershipDeedFile')->getClientOriginalName();
            $partFilename = pathinfo($partFileNameWithExtention, PATHINFO_FILENAME);
            $partExtention = $request->file('partnershipDeedFile')->getClientOriginalExtension();
            $partFileNameToStore = $partFilename.'_'.time().'.'.$partExtention;
            $partPath = $request->file('partnershipDeedFile')->storeAs('public/BusinessAsset/partnershipDeedFile', $partFileNameToStore);
         }

         if($request->hasFile('jvAgreementFile')){
            $jvFileNameWithExtention = $request->file('jvAgreementFile')->getClientOriginalName();
            $jvFilename = pathinfo($jvFileNameWithExtention, PATHINFO_FILENAME);
            $jvExtention = $request->file('jvAgreementFile')->getClientOriginalExtension();
            $jvFileNameToStore = $jvFilename.'_'.time().'.'.$jvExtention;
            $jvPath = $request->file('jvAgreementFile')->storeAs('public/BusinessAsset/jvAgreementFile', $jvFileNameToStore);
         }

         if($request->hasFile('loanDepositeReceipt')){
            $loanFileNameWithExtention = $request->file('loanDepositeReceipt')->getClientOriginalName();
            $loanFilename = pathinfo($loanFileNameWithExtention, PATHINFO_FILENAME);
            $loanExtention = $request->file('loanDepositeReceipt')->getClientOriginalExtension();
            $loanFileNameToStore = $loanFilename.'_'.time().'.'.$loanExtention;
            $loanPath = $request->file('loanDepositeReceipt')->storeAs('public/BusinessAsset/loanDepositeReceipt', $loanFileNameToStore);
         }

         if($request->hasFile('promisoryNote')){
            $pnFileNameWithExtention = $request->file('promisoryNote')->getClientOriginalName();
            $pnFilename = pathinfo($pnFileNameWithExtention, PATHINFO_FILENAME);
            $pnExtention = $request->file('promisoryNote')->getClientOriginalExtension();
            $pnFileNameToStore = $pnFilename.'_'.time().'.'.$pnExtention;
            $pnPath = $request->file('promisoryNote')->storeAs('public/BusinessAsset/promisoryNote', $pnFileNameToStore);
         }


        $user = Auth::user();
        $businessAsset = new BusinessAsset();
        $businessAsset->profile_id = $user->profile->id;
        $businessAsset->type = $request->input('type');
        $businessAsset->firm_name = $request->input('firmName');
        $businessAsset->registered_address = $request->input('registeredAddress');
        $businessAsset->firm_no_type = $request->input('firmsRegistrationNumberType');
        $businessAsset->firms_registration_number = $request->input('firmsRegistrationNumber');
        $businessAsset->holding_percentage = $request->input('holdingPercentage');
        $businessAsset->company_name = $request->input('companyName');
        $businessAsset->company_address = $request->input('companyAddress');
        $businessAsset->my_status = $request->input('myStatus');
        $businessAsset->type_of_investment = $request->input('typeOfInvestment');
        $businessAsset->holding_type = $request->input('holdingType');
        $businessAsset->joint_holder_name = $request->input('jointHolderName');
        $businessAsset->joint_holder_pan = $request->input('jointHolderPan');
        $businessAsset->document_availability = json_encode($request->input('documentAvailability'));
        if($request->hasFile('shareCentificateFile')){
            $businessAsset->share_centificate_file = $shareFileNameToStore;
         } 
         if($request->hasFile('partnershipDeedFile')){
            $businessAsset->partnership_deed_file = $partFileNameToStore;
         } 
         if($request->hasFile('jvAgreementFile')){
            $businessAsset->jv_agreement_file = $jvFileNameToStore;
         } 
         if($request->hasFile('loanDepositeReceipt')){
            $businessAsset->loan_deposite_receipt = $loanFileNameToStore;
         } 
         if($request->hasFile('promisoryNote')){
            $businessAsset->promisory_note = $pnFileNameToStore;
         } 
         $businessAsset->type_of_ip = $request->input('typeOfIp');
         $businessAsset->expiry_date = $request->input('expiryDate');
         $businessAsset->whether_assigned = $request->input('whetherAssigned');
         $businessAsset->name_of_assignee = $request->input('nameOfAssignee');
         $businessAsset->date_of_assignment = $request->input('dateOfAssignment');
         $businessAsset->additional_information = $request->input('additionalInformation');
         $businessAsset->name = $request->input('name');
         $businessAsset->mobile = $request->input('mobile');
         $businessAsset->email = $request->input('email');
         $businessAsset->save();
        
         // if($request->has('nominees')){
         //       $nominee_id = $request->input('nominees');
         //       $businessAsset->nominee()->attach($nominee_id);
         // }

         if($request->has('nominees')) {
            $nominee_id = $request->input('nominees');
            if(is_string($nominee_id)) {
                $nominee_id = explode(',', $nominee_id);
            }
            if(is_array($nominee_id)) {
                $nominee_id = array_map('intval', $nominee_id);
                $businessAsset->nominee()->attach($nominee_id);
            }
        }

        return $this->sendResponse(['BusinessAsset'=> new BusinessAssetsResource($businessAsset)], 'Business Asset details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $businessAsset = BusinessAsset::find($id);
        if(!$businessAsset){
            return $this->sendError('Business Assets Not Found',['error'=>'Business Assets not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $businessAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Business Assets']);
         }
         $businessAsset->load('nominee'); 
        return $this->sendResponse(['BusinessAsset'=>new BusinessAssetsResource($businessAsset)], 'Business Asset retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessAssetRequest $request, string $id): JsonResponse
    {
      
        if($request->hasFile('shareCentificateFile')){
            $shareFileNameWithExtention = $request->file('shareCentificateFile')->getClientOriginalName();
            $shareFilename = pathinfo($shareFileNameWithExtention, PATHINFO_FILENAME);
            $shareExtention = $request->file('shareCentificateFile')->getClientOriginalExtension();
            $shareFileNameToStore = $shareFilename.'_'.time().'.'.$shareExtention;
            $sharePath = $request->file('shareCentificateFile')->storeAs('public/BusinessAsset/shareCentificateFile', $shareFileNameToStore);
         }

         if($request->hasFile('partnershipDeedFile')){
            $partFileNameWithExtention = $request->file('partnershipDeedFile')->getClientOriginalName();
            $partFilename = pathinfo($partFileNameWithExtention, PATHINFO_FILENAME);
            $partExtention = $request->file('partnershipDeedFile')->getClientOriginalExtension();
            $partFileNameToStore = $partFilename.'_'.time().'.'.$partExtention;
            $partPath = $request->file('partnershipDeedFile')->storeAs('public/BusinessAsset/partnershipDeedFile', $partFileNameToStore);
         }

         if($request->hasFile('jvAgreementFile')){
            $jvFileNameWithExtention = $request->file('jvAgreementFile')->getClientOriginalName();
            $jvFilename = pathinfo($jvFileNameWithExtention, PATHINFO_FILENAME);
            $jvExtention = $request->file('jvAgreementFile')->getClientOriginalExtension();
            $jvFileNameToStore = $jvFilename.'_'.time().'.'.$jvExtention;
            $jvPath = $request->file('jvAgreementFile')->storeAs('public/BusinessAsset/jvAgreementFile', $jvFileNameToStore);
         }

         if($request->hasFile('loanDepositeReceipt')){
            $loanFileNameWithExtention = $request->file('loanDepositeReceipt')->getClientOriginalName();
            $loanFilename = pathinfo($loanFileNameWithExtention, PATHINFO_FILENAME);
            $loanExtention = $request->file('loanDepositeReceipt')->getClientOriginalExtension();
            $loanFileNameToStore = $loanFilename.'_'.time().'.'.$loanExtention;
            $loanPath = $request->file('loanDepositeReceipt')->storeAs('public/BusinessAsset/loanDepositeReceipt', $loanFileNameToStore);
         }

         if($request->hasFile('promisoryNote')){
            $pnFileNameWithExtention = $request->file('promisoryNote')->getClientOriginalName();
            $pnFilename = pathinfo($pnFileNameWithExtention, PATHINFO_FILENAME);
            $pnExtention = $request->file('promisoryNote')->getClientOriginalExtension();
            $pnFileNameToStore = $pnFilename.'_'.time().'.'.$pnExtention;
            $pnPath = $request->file('promisoryNote')->storeAs('public/BusinessAsset/promisoryNote', $pnFileNameToStore);
         }


        $businessAsset = BusinessAsset::find($id);
        if(!$businessAsset){
            return $this->sendError('Business asset Not Found',['error'=>'Business Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $businessAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Business Asset']);
         }

        $businessAsset->type = $request->input('type');
        $businessAsset->firm_name = $request->input('firmName');
        $businessAsset->registered_address = $request->input('registeredAddress');
        $businessAsset->firm_no_type = $request->input('firmsRegistrationNumberType');
        $businessAsset->firms_registration_number = $request->input('firmsRegistrationNumber');
        $businessAsset->holding_percentage = $request->input('holdingPercentage');
        $businessAsset->company_name = $request->input('companyName');
        $businessAsset->company_address = $request->input('companyAddress');
        $businessAsset->my_status = $request->input('myStatus');
        $businessAsset->type_of_investment = $request->input('typeOfInvestment');
        $businessAsset->holding_type = $request->input('holdingType');
        $businessAsset->joint_holder_name = $request->input('jointHolderName');
        $businessAsset->joint_holder_pan = $request->input('jointHolderPan');
        $businessAsset->document_availability = json_encode($request->input('documentAvailability'));
        if($request->hasFile('shareCentificateFile')){
            $businessAsset->share_centificate_file = $shareFileNameToStore;
         } 
         if($request->hasFile('partnershipDeedFile')){
            $businessAsset->partnership_deed_file = $partFileNameToStore;
         } 
         if($request->hasFile('jvAgreementFile')){
            $businessAsset->jv_agreement_file = $jvFileNameToStore;
         } 
         if($request->hasFile('loanDepositeReceipt')){
            $businessAsset->loan_deposite_receipt = $loanFileNameToStore;
         } 
         if($request->hasFile('promisoryNote')){
            $businessAsset->promisory_note = $pnFileNameToStore;
         } 
        $businessAsset->type_of_ip = $request->input('typeOfIp');
        $businessAsset->expiry_date = $request->input('expiryDate');
        $businessAsset->whether_assigned = $request->input('whetherAssigned');
        $businessAsset->name_of_assignee = $request->input('nameOfAssignee');
        $businessAsset->date_of_assignment = $request->input('dateOfAssignment');
        $businessAsset->additional_information = $request->input('additionalInformation');
        $businessAsset->name = $request->input('name');
        $businessAsset->mobile = $request->input('mobile');
        $businessAsset->email = $request->input('email');
        $businessAsset->save();

      //   if($request->has('nominees')) {
      //       $nominee_ids = $request->input('nominees');
      //       $businessAsset->nominee()->sync($nominee_ids);
      //   }else {
      //       $businessAsset->nominee()->detach();
      //   }

      if($request->has('nominees')) {
         $nominee_id = is_string($request->input('nominees')) 
         ? explode(',', $request->input('nominees')) 
         : $request->input('nominees');
         $nominee_id = array_map('intval', $nominee_id);
         $businessAsset->nominee()->sync($nominee_id);
      }else {
          $businessAsset->nominee()->detach();
     }

         return $this->sendResponse(['BusinessAsset'=> new BusinessAssetsResource($businessAsset)], 'Business Asset details updated successfully');
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $businessAsset = BusinessAsset::find($id);
        if(!$businessAsset){
            return $this->sendError('Broking Account not found', ['error'=>'Business Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $businessAsset->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Business Asset']);
        }
        $businessAsset->delete();

        return $this->sendResponse([], 'Business Asset deleted successfully');
    }
}