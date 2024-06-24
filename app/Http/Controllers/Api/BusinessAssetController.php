<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BusinessAsset;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BusinessAssetsResource;

class BusinessAssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $propritership = auth()->user()->profile->businessAsset()->where('type', 'propritership')->get();
        $partnershipFirm = auth()->user()->profile->businessAsset()->where('type', 'partnershipFirm')->get();
        $company = auth()->user()->profile->businessAsset()->where('type', 'company')->get();
        $intellectualProperty = auth()->user()->profile->businessAsset()->where('type', 'intellectualProperty')->get();

       return $this->sendResponse(['Propritership'=>BusinessAssetsResource::collection($propritership), 'PartnershipFirm'=>BusinessAssetsResource::collection($partnershipFirm),'Company'=>BusinessAssetsResource::collection($company),'IntellectualProperty'=>BusinessAssetsResource::collection($intellectualProperty)], "Business Assets retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
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
        $businessAsset->firm_no_type = $request->input('firmNoType');
        $businessAsset->firms_registration_number = $request->input('firmsRegistrationNumber');
        $businessAsset->holding_percentage = $request->input('holdingPercentage');
        $businessAsset->company_name = $request->input('companyName');
        $businessAsset->company_address = $request->input('companyAddress');
        $businessAsset->my_status = $request->input('myStatus');
        $businessAsset->type_of_investment = $request->input('typeOfInvestment');
        $businessAsset->holding_type = $request->input('holdingType');
        $businessAsset->document_availability = $request->input('documentAvailability');
        if($request->hasFile('shareCentificateFile')){
            $businessAsset->share_centificate_file = $sharePath;
         } 
         if($request->hasFile('partnershipDeedFile')){
            $businessAsset->partnership_deed_file = $partPath;
         } 
         if($request->hasFile('jvAgreementFile')){
            $businessAsset->jv_agreement_file = $jvPath;
         } 
         if($request->hasFile('loanDepositeReceipt')){
            $businessAsset->loan_deposite_receipt = $loanPath;
         } 
         if($request->hasFile('promisoryNote')){
            $businessAsset->promisory_note = $pnPath;
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
        
        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $businessAsset->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $businessAsset->jointHolder()->attach($joint_holder_id);
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
         $businessAsset->load('nominee','jointHolder'); 
        return $this->sendResponse(['BusinessAsset'=>new BusinessAssetsResource($businessAsset)], 'Business Asset retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
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




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //
    }
}
