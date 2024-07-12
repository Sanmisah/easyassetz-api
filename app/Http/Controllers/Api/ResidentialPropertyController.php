<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ResidentialProperty;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ResidentialPropertyResource;

class ResidentialPropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $residentialProperty = $user->profile->residentialProperty()->with('nominee')->get();
        return $this->sendResponse(['ResidentialProperty'=>ResidentialPropertyResource::collection($residentialProperty)],'Residential Property details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('litigationFile')){
            $litigationFileNameWithExtention = $request->file('litigationFile')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('litigationFile')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('litigationFile')->storeAs('public/ResidentialProperty/LitigationFiles', $portfolioFileNameToStore);
         }

         if($request->hasFile('agreementCopy')){
            $agreementCopyFileNameWithExtention = $request->file('agreementCopy')->getClientOriginalName();
            $agreementCopyFilename = pathinfo($agreementCopyFileNameWithExtention, PATHINFO_FILENAME);
            $agreementCopyExtention = $request->file('agreementCopy')->getClientOriginalExtension();
            $agreementCopyFileNameToStore = $agreementCopyFilename.'_'.time().'.'.$agreementCopyExtention;
            $agreementCopyPath = $request->file('agreementCopy')->storeAs('public/ResidentialProperty/AgreementCopy', $agreementCopyFileNameToStore);
         }

         if($request->hasFile('rentAgreementFile')){
            $rentAgreementFileNameWithExtention = $request->file('rentAgreementFile')->getClientOriginalName();
            $rentAgreementFilename = pathinfo($rentAgreementFileNameWithExtention, PATHINFO_FILENAME);
            $rentAgreementExtention = $request->file('rentAgreementFile')->getClientOriginalExtension();
            $rentAgreementFileNameToStore = $rentAgreementFilename.'_'.time().'.'.$rentAgreementExtention;
            $rentAgreementPath = $request->file('rentAgreementFile')->storeAs('public/ResidentialProperty/RentAgreementFile', $rentAgreementFileNameToStore);
         }

         if($request->hasFile('shareCertificateFile')){
            $shareCertificateFileNameWithExtention = $request->file('shareCertificateFile')->getClientOriginalName();
            $shareCertificateFilename = pathinfo($shareCertificateFileNameWithExtention, PATHINFO_FILENAME);
            $shareCertificateExtention = $request->file('shareCertificateFile')->getClientOriginalExtension();
            $shareCertificateFileNameToStore = $shareCertificateFilename.'_'.time().'.'.$shareCertificateExtention;
            $shareCertificatePath = $request->file('shareCertificateFile')->storeAs('public/ResidentialProperty/ShareCertificateFile', $shareCertificateFileNameToStore);
         }

         if($request->hasFile('leaseDocumentFile')){
            $leaseDocumentFileNameWithExtention = $request->file('leaseDocumentFile')->getClientOriginalName();
            $leaseDocumentFilename = pathinfo($leaseDocumentFileNameWithExtention, PATHINFO_FILENAME);
            $leaseDocumentExtention = $request->file('leaseDocumentFile')->getClientOriginalExtension();
            $leaseDocumentFileNameToStore = $leaseDocumentFilename.'_'.time().'.'.$leaseDocumentExtention;
            $leaseDocumentPath = $request->file('leaseDocumentFile')->storeAs('public/ResidentialProperty/leaseDocumentFile', $leaseDocumentFileNameToStore);
         }

        $user = Auth::user();
        $residentialProperty = new ResidentialProperty();
        $residentialProperty->profile_id = $user->profile->id;
        $residentialProperty->property_type = $request->input('propertyType');
        $residentialProperty->house_number = $request->input('houseNumber');
        $residentialProperty->address_1 = $request->input('address1');
        $residentialProperty->pincode = $request->input('pincode');
        $residentialProperty->area = $request->input('area');
        $residentialProperty->city = $request->input('city');
        $residentialProperty->state = $request->input('state');
        $residentialProperty->property_status = $request->input('propertyStatus');
        $residentialProperty->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
        $residentialProperty->ownership_type = $request->input('ownershipType');
        $residentialProperty->first_holders_name = $request->input('firstHoldersName');
        $residentialProperty->first_holders_relation = $request->input('firstHoldersRelation');
        $residentialProperty->first_holders_aadhar = $request->input('firstHoldersAadhar');
        $residentialProperty->first_holders_pan = $request->input('firstHoldersPan');
        $residentialProperty->joint_holders_name = $request->input('jointHoldersName');
        $residentialProperty->joint_holders_relation = $request->input('jointHoldersRelation');
        $residentialProperty->joint_holders_pan = $request->input('jointHoldersPan');
        $residentialProperty->any_loan_litigation = $request->input('anyLoanLitigation');
        if($request->hasFile('litigationFile')){
            $residentialProperty->litigation_file = $litigationFileNameToStore;
         } 

         if($request->hasFile('agreementCopy')){
            $residentialProperty->agreement_file = $agreementCopyFileNameToStore;
         } 
        if($request->hasFile('rentAgreementFile')){
            $residentialProperty->rent_agreement_file = $rentAgreementFileNameToStore;
         }
        if($request->hasFile('shareCertificateFile')){
            $residentialProperty->share_certificate_file = $shareCertificateFileNameToStore;
         }
         if($request->hasFile('leaseDocumentFile')){
            $residentialProperty->lease_document_file = $leaseDocumentFileNameToStore;
         } 
        $residentialProperty->name = $request->input('name');
        $residentialProperty->mobile = $request->input('mobile');
        $residentialProperty->email = $request->input('email');
        $residentialProperty->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $residentialProperty->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['ResidentialProperty'=> new ResidentialPropertyResource($residentialProperty)], 'Residential Property details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $residentialProperty = ResidentialProperty::find($id);
        if(!$residentialProperty){
            return $this->sendError('Residential Property Not Found',['error'=>'Residential Property not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $residentialProperty->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Residential Property']);
         }
         $residentialProperty->load('nominee');
        return $this->sendResponse(['ResidentialProperty'=>new ResidentialPropertyResource($residentialProperty)], 'Residential Property retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('litigationFile')){
            $litigationFileNameWithExtention = $request->file('litigationFile')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('litigationFile')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('litigationFile')->storeAs('public/ResidentialProperty/LitigationFiles', $portfolioFileNameToStore);
         }

         if($request->hasFile('agreementCopy')){
            $agreementCopyFileNameWithExtention = $request->file('agreementCopy')->getClientOriginalName();
            $agreementCopyFilename = pathinfo($agreementCopyFileNameWithExtention, PATHINFO_FILENAME);
            $agreementCopyExtention = $request->file('agreementCopy')->getClientOriginalExtension();
            $agreementCopyFileNameToStore = $agreementCopyFilename.'_'.time().'.'.$agreementCopyExtention;
            $agreementCopyPath = $request->file('agreementCopy')->storeAs('public/ResidentialProperty/AgreementCopy', $agreementCopyFileNameToStore);
         }

         if($request->hasFile('rentAgreementFile')){
            $rentAgreementFileNameWithExtention = $request->file('rentAgreementFile')->getClientOriginalName();
            $rentAgreementFilename = pathinfo($rentAgreementFileNameWithExtention, PATHINFO_FILENAME);
            $rentAgreementExtention = $request->file('rentAgreementFile')->getClientOriginalExtension();
            $rentAgreementFileNameToStore = $rentAgreementFilename.'_'.time().'.'.$rentAgreementExtention;
            $rentAgreementPath = $request->file('rentAgreementFile')->storeAs('public/ResidentialProperty/RentAgreementFile', $rentAgreementFileNameToStore);
         }

         if($request->hasFile('shareCertificateFile')){
            $shareCertificateFileNameWithExtention = $request->file('shareCertificateFile')->getClientOriginalName();
            $shareCertificateFilename = pathinfo($shareCertificateFileNameWithExtention, PATHINFO_FILENAME);
            $shareCertificateExtention = $request->file('shareCertificateFile')->getClientOriginalExtension();
            $shareCertificateFileNameToStore = $shareCertificateFilename.'_'.time().'.'.$shareCertificateExtention;
            $shareCertificatePath = $request->file('shareCertificateFile')->storeAs('public/ResidentialProperty/ShareCertificateFile', $shareCertificateFileNameToStore);
         }

         if($request->hasFile('leaseDocumentFile')){
            $leaseDocumentFileNameWithExtention = $request->file('leaseDocumentFile')->getClientOriginalName();
            $leaseDocumentFilename = pathinfo($leaseDocumentFileNameWithExtention, PATHINFO_FILENAME);
            $leaseDocumentExtention = $request->file('leaseDocumentFile')->getClientOriginalExtension();
            $leaseDocumentFileNameToStore = $leaseDocumentFilename.'_'.time().'.'.$leaseDocumentExtention;
            $leaseDocumentPath = $request->file('leaseDocumentFile')->storeAs('public/ResidentialProperty/leaseDocumentFile', $leaseDocumentFileNameToStore);
         }

         $residentialProperty = ResidentialProperty::find($id);
         if(!$residentialProperty){
             return $this->sendError('Residential Property Not Found',['error'=>'Residential Property details not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $residentialProperty->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Residential Property details']);
          }

          $residentialProperty->property_type = $request->input('propertyType');
          $residentialProperty->house_number = $request->input('houseNumber');
          $residentialProperty->address_1 = $request->input('address1');
          $residentialProperty->pincode = $request->input('pincode');
          $residentialProperty->area = $request->input('area');
          $residentialProperty->city = $request->input('city');
          $residentialProperty->state = $request->input('state');
          $residentialProperty->property_status = $request->input('propertyStatus');
          $residentialProperty->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
          $residentialProperty->ownership_type = $request->input('ownershipType');
          $residentialProperty->first_holders_name = $request->input('firstHoldersName');
          $residentialProperty->first_holders_relation = $request->input('firstHoldersRelation');
          $residentialProperty->first_holders_aadhar = $request->input('firstHoldersAadhar');
          $residentialProperty->first_holders_pan = $request->input('firstHoldersPan');
          $residentialProperty->joint_holders_name = $request->input('jointHoldersName');
          $residentialProperty->joint_holders_relation = $request->input('jointHoldersRelation');
          $residentialProperty->joint_holders_pan = $request->input('jointHoldersPan');
          $residentialProperty->any_loan_litigation = $request->input('anyLoanLitigation');
          if($request->hasFile('litigationFile')){
            $residentialProperty->litigation_file = $litigationFileNameToStore;
         } 
         if($request->hasFile('agreementCopy')){
            $residentialProperty->agreement_file = $agreementCopyFileNameToStore;
         } 
           if($request->hasFile('rentAgreementFile')){
            $residentialProperty->rent_agreement_file = $rentAgreementFileNameToStore;
         }
            if($request->hasFile('shareCertificateFile')){
            $residentialProperty->share_certificate_file = $shareCertificateFileNameToStore;
         }
            if($request->hasFile('leaseDocumentFile')){
            $residentialProperty->lease_document_file = $leaseDocumentFileNameToStore;
         } 
          $residentialProperty->name = $request->input('name');
          $residentialProperty->mobile = $request->input('mobile');
          $residentialProperty->email = $request->input('email');
          $residentialProperty->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $residentialProperty->nominee()->sync($nominee_ids);
        }else {
            $residentialProperty->nominee()->detach();
        }
       
        return $this->sendResponse(['ResidentialProperty'=>new ResidentialPropertyResource($residentialProperty)], 'Residential Property details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $residentialProperty = ResidentialProperty::find($id);
        if(!$residentialProperty){
            return $this->sendError('Residential Property not found', ['error'=>'Residential Property not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $residentialProperty->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Residential Property']);
        }
        $residentialProperty->delete();

        return $this->sendResponse([], 'Residential Property deleted successfully');
    }
}
