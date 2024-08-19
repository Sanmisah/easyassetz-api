<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CommercialProperty;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\CommercialPropertyResource;
use App\Http\Requests\StoreCommercialPropertyRequest;
use App\Http\Requests\UpdateCommercialPropertyRequest;

class CommercialPropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $commercialProperty = $user->profile->commercialProperty()->with('nominee')->get();
        return $this->sendResponse(['CommercialProperty'=>CommercialPropertyResource::collection($commercialProperty)],'Commercial Property details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommercialPropertyRequest $request): JsonResponse
    {
        if($request->hasFile('litigationFile')){
            $litigationFileNameWithExtention = $request->file('litigationFile')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('litigationFile')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('litigationFile')->storeAs('public/CommercialProperty/LitigationFiles', $portfolioFileNameToStore);
         }

         if($request->hasFile('agreementCopy')){
            $agreementCopyFileNameWithExtention = $request->file('agreementCopy')->getClientOriginalName();
            $agreementCopyFilename = pathinfo($agreementCopyFileNameWithExtention, PATHINFO_FILENAME);
            $agreementCopyExtention = $request->file('agreementCopy')->getClientOriginalExtension();
            $agreementCopyFileNameToStore = $agreementCopyFilename.'_'.time().'.'.$agreementCopyExtention;
            $agreementCopyPath = $request->file('agreementCopy')->storeAs('public/CommercialProperty/AgreementCopy', $agreementCopyFileNameToStore);
         }

         if($request->hasFile('rentAgreementFile')){
            $rentAgreementFileNameWithExtention = $request->file('rentAgreementFile')->getClientOriginalName();
            $rentAgreementFilename = pathinfo($rentAgreementFileNameWithExtention, PATHINFO_FILENAME);
            $rentAgreementExtention = $request->file('rentAgreementFile')->getClientOriginalExtension();
            $rentAgreementFileNameToStore = $rentAgreementFilename.'_'.time().'.'.$rentAgreementExtention;
            $rentAgreementPath = $request->file('rentAgreementFile')->storeAs('public/CommercialProperty/RentAgreementFile', $rentAgreementFileNameToStore);
         }

         if($request->hasFile('shareCertificateFile')){
            $shareCertificateFileNameWithExtention = $request->file('shareCertificateFile')->getClientOriginalName();
            $shareCertificateFilename = pathinfo($shareCertificateFileNameWithExtention, PATHINFO_FILENAME);
            $shareCertificateExtention = $request->file('shareCertificateFile')->getClientOriginalExtension();
            $shareCertificateFileNameToStore = $shareCertificateFilename.'_'.time().'.'.$shareCertificateExtention;
            $shareCertificatePath = $request->file('shareCertificateFile')->storeAs('public/CommercialProperty/ShareCertificateFile', $shareCertificateFileNameToStore);
         }

         if($request->hasFile('leaseDocumentFile')){
            $leaseDocumentFileNameWithExtention = $request->file('leaseDocumentFile')->getClientOriginalName();
            $leaseDocumentFilename = pathinfo($leaseDocumentFileNameWithExtention, PATHINFO_FILENAME);
            $leaseDocumentExtention = $request->file('leaseDocumentFile')->getClientOriginalExtension();
            $leaseDocumentFileNameToStore = $leaseDocumentFilename.'_'.time().'.'.$leaseDocumentExtention;
            $leaseDocumentPath = $request->file('leaseDocumentFile')->storeAs('public/CommercialProperty/LeaseDocumentFile', $leaseDocumentFileNameToStore);
         }

        $user = Auth::user();
        $commercialProperty = new CommercialProperty();
        $commercialProperty->profile_id = $user->profile->id;
        $commercialProperty->property_type = $request->input('propertyType');
        $commercialProperty->house_number = $request->input('houseNumber');
        $commercialProperty->address_1 = $request->input('address1');
        $commercialProperty->pincode = $request->input('pincode');
        $commercialProperty->area = $request->input('area');
        $commercialProperty->city = $request->input('city');
        $commercialProperty->state = $request->input('state');
        $commercialProperty->property_status = $request->input('propertyStatus');
        $commercialProperty->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
        $commercialProperty->ownership_type = $request->input('ownershipType');
        $commercialProperty->first_holders_name = $request->input('firstHoldersName');
        $commercialProperty->first_holders_relation = $request->input('firstHoldersRelation');
        $commercialProperty->first_holders_aadhar = $request->input('firstHoldersAadhar');
        $commercialProperty->first_holders_pan = $request->input('firstHoldersPan');
        $commercialProperty->joint_holders_name = $request->input('jointHoldersName');
        $commercialProperty->joint_holders_relation = $request->input('jointHoldersRelation');
        $commercialProperty->joint_holders_aadhar = $request->input('jointHoldersAadhar');
        $commercialProperty->joint_holders_pan = $request->input('jointHoldersPan');
        $commercialProperty->any_loan_litigation = $request->input('anyLoanLitigation');
        if($request->hasFile('litigationFile')){
            $commercialProperty->litigation_file = $litigationFileNameToStore;
         } 

         if($request->hasFile('agreementCopy')){
            $commercialProperty->agreement_file = $agreementCopyFileNameToStore;
         } 
        if($request->hasFile('rentAgreementFile')){
            $commercialProperty->rent_agreement_file = $rentAgreementFileNameToStore;
         }
        if($request->hasFile('shareCertificateFile')){
            $commercialProperty->share_certificate_file = $shareCertificateFileNameToStore;
         }
         if($request->hasFile('leaseDocumentFile')){
            $commercialProperty->lease_document_file = $leaseDocumentFileNameToStore;
         } 
        $commercialProperty->name = $request->input('name');
        $commercialProperty->mobile = $request->input('mobile');
        $commercialProperty->email = $request->input('email');
        $commercialProperty->save();

         if($request->has('nominees')) {
            $nominee_id = $request->input('nominees');
            if(is_string($nominee_id)) {
               $nominee_id = explode(',', $nominee_id);
            }
            if(is_array($nominee_id)) {
               $nominee_id = array_map('intval', $nominee_id);
               $commercialProperty->nominee()->attach($nominee_id);
            }
      }

        return $this->sendResponse(['CommercialProperty'=> new CommercialPropertyResource($commercialProperty)], 'Commercial Property details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $commercialProperty = CommercialProperty::find($id);
        if(!$commercialProperty){
            return $this->sendError('Commercial Property Not Found',['error'=>'Commercial Property not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $commercialProperty->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Commercial Property']);
         }
         $commercialProperty->load('nominee');
        return $this->sendResponse(['CommercialProperty'=>new CommercialPropertyResource($commercialProperty)], 'Commercial Property retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommercialPropertyRequest $request, string $id): JsonResponse
    {
      $commercialProperty = CommercialProperty::find($id);
      if(!$commercialProperty){
          return $this->sendError('Commercial Property Not Found',['error'=>'Commercial Property details not found']);
      }
      $user = Auth::user();
      if($user->profile->id !== $commercialProperty->profile_id){
         return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Commercial Property details']);
       }

        if($request->hasFile('litigationFile')){

         if (!empty($commercialProperty->litigation_file) && Storage::exists('public/CommercialProperty/LitigationFiles/'.$commercialProperty->litigation_file)) {
            Storage::delete('public/CommercialProperty/LitigationFiles/'.$commercialProperty->litigation_file);
           }

            $litigationFileNameWithExtention = $request->file('litigationFile')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('litigationFile')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('litigationFile')->storeAs('public/CommercialProperty/LitigationFiles', $portfolioFileNameToStore);
         }

         if($request->hasFile('agreementCopy')){

            if (!empty($commercialProperty->agreement_file) && Storage::exists('public/CommercialProperty/AgreementCopy/'.$commercialProperty->agreement_file)) {
               Storage::delete('public/CommercialProperty/AgreementCopy/'.$commercialProperty->agreement_file);
              }

            $agreementCopyFileNameWithExtention = $request->file('agreementCopy')->getClientOriginalName();
            $agreementCopyFilename = pathinfo($agreementCopyFileNameWithExtention, PATHINFO_FILENAME);
            $agreementCopyExtention = $request->file('agreementCopy')->getClientOriginalExtension();
            $agreementCopyFileNameToStore = $agreementCopyFilename.'_'.time().'.'.$agreementCopyExtention;
            $agreementCopyPath = $request->file('agreementCopy')->storeAs('public/CommercialProperty/AgreementCopy', $agreementCopyFileNameToStore);
         }

         if($request->hasFile('rentAgreementFile')){
            if (!empty($commercialProperty->rent_agreement_file) && Storage::exists('public/CommercialProperty/RentAgreementFile/'.$commercialProperty->rent_agreement_file)) {
               Storage::delete('public/CommercialProperty/RentAgreementFile/'.$commercialProperty->rent_agreement_file);
              }
            $rentAgreementFileNameWithExtention = $request->file('rentAgreementFile')->getClientOriginalName();
            $rentAgreementFilename = pathinfo($rentAgreementFileNameWithExtention, PATHINFO_FILENAME);
            $rentAgreementExtention = $request->file('rentAgreementFile')->getClientOriginalExtension();
            $rentAgreementFileNameToStore = $rentAgreementFilename.'_'.time().'.'.$rentAgreementExtention;
            $rentAgreementPath = $request->file('rentAgreementFile')->storeAs('public/CommercialProperty/RentAgreementFile', $rentAgreementFileNameToStore);
         }

         if($request->hasFile('shareCertificateFile')){
            if (!empty($commercialProperty->share_certificate_file) && Storage::exists('public/CommercialProperty/ShareCertificateFile/'.$commercialProperty->share_certificate_file)) {
               Storage::delete('public/CommercialProperty/ShareCertificateFile/'.$commercialProperty->share_certificate_file);
              }
            $shareCertificateFileNameWithExtention = $request->file('shareCertificateFile')->getClientOriginalName();
            $shareCertificateFilename = pathinfo($shareCertificateFileNameWithExtention, PATHINFO_FILENAME);
            $shareCertificateExtention = $request->file('shareCertificateFile')->getClientOriginalExtension();
            $shareCertificateFileNameToStore = $shareCertificateFilename.'_'.time().'.'.$shareCertificateExtention;
            $shareCertificatePath = $request->file('shareCertificateFile')->storeAs('public/CommercialProperty/ShareCertificateFile', $shareCertificateFileNameToStore);
         }

         if($request->hasFile('leaseDocumentFile')){
            if (!empty($commercialProperty->lease_document_file) && Storage::exists('public/CommercialProperty/LeaseDocumentFile/'.$commercialProperty->lease_document_file)) {
               Storage::delete('public/CommercialProperty/LeaseDocumentFile/'.$commercialProperty->lease_document_file);
              }
            $leaseDocumentFileNameWithExtention = $request->file('leaseDocumentFile')->getClientOriginalName();
            $leaseDocumentFilename = pathinfo($leaseDocumentFileNameWithExtention, PATHINFO_FILENAME);
            $leaseDocumentExtention = $request->file('leaseDocumentFile')->getClientOriginalExtension();
            $leaseDocumentFileNameToStore = $leaseDocumentFilename.'_'.time().'.'.$leaseDocumentExtention;
            $leaseDocumentPath = $request->file('leaseDocumentFile')->storeAs('public/CommercialProperty/LeaseDocumentFile', $leaseDocumentFileNameToStore);
         }

          $commercialProperty->property_type = $request->input('propertyType');
          $commercialProperty->house_number = $request->input('houseNumber');
          $commercialProperty->address_1 = $request->input('address1');
          $commercialProperty->pincode = $request->input('pincode');
          $commercialProperty->area = $request->input('area');
          $commercialProperty->city = $request->input('city');
          $commercialProperty->state = $request->input('state');
          $commercialProperty->property_status = $request->input('propertyStatus');
          $commercialProperty->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
          $commercialProperty->ownership_type = $request->input('ownershipType');
          $commercialProperty->first_holders_name = $request->input('firstHoldersName');
          $commercialProperty->first_holders_relation = $request->input('firstHoldersRelation');
          $commercialProperty->first_holders_aadhar = $request->input('firstHoldersAadhar');
          $commercialProperty->first_holders_pan = $request->input('firstHoldersPan');
          $commercialProperty->joint_holders_name = $request->input('jointHoldersName');
          $commercialProperty->joint_holders_relation = $request->input('jointHoldersRelation');
          $commercialProperty->joint_holders_aadhar = $request->input('jointHoldersAadhar');
          $commercialProperty->joint_holders_pan = $request->input('jointHoldersPan');
          $commercialProperty->any_loan_litigation = $request->input('anyLoanLitigation');
          if($request->hasFile('litigationFile')){
            $commercialProperty->litigation_file = $litigationFileNameToStore;
         } 
         if($request->hasFile('agreementCopy')){
            $commercialProperty->agreement_file = $agreementCopyFileNameToStore;
         } 
           if($request->hasFile('rentAgreementFile')){
            $commercialProperty->rent_agreement_file = $rentAgreementFileNameToStore;
         }
            if($request->hasFile('shareCertificateFile')){
            $commercialProperty->share_certificate_file = $shareCertificateFileNameToStore;
         }
            if($request->hasFile('leaseDocumentFile')){
            $commercialProperty->lease_document_file = $leaseDocumentFileNameToStore;
         } 
          $commercialProperty->name = $request->input('name');
          $commercialProperty->mobile = $request->input('mobile');
          $commercialProperty->email = $request->input('email');
          $commercialProperty->save();

          if($request->has('nominees')) {
            $nominee_id = is_string($request->input('nominees')) 
            ? explode(',', $request->input('nominees')) 
            : $request->input('nominees');
            $nominee_id = array_map('intval', $nominee_id);
            $commercialProperty->nominee()->sync($nominee_id);
         }else {
             $commercialProperty->nominee()->detach();
        }
       
        return $this->sendResponse(['CommercialProperty'=>new CommercialPropertyResource($commercialProperty)], 'Commercial Property details Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $commercialProperty = CommercialProperty::find($id);
        if(!$commercialProperty){
            return $this->sendError('Commercial Property not found', ['error'=>'Commercial Property not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $commercialProperty->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Commercial Property']);
        }
        
        if (!empty($commercialProperty->litigation_file) && Storage::exists('public/CommercialProperty/LitigationFiles/'.$commercialProperty->litigation_file)) {
         Storage::delete('public/CommercialProperty/LitigationFiles/'.$commercialProperty->litigation_file);
        }

        if (!empty($commercialProperty->agreement_file) && Storage::exists('public/CommercialProperty/AgreementCopy/'.$commercialProperty->agreement_file)) {
         Storage::delete('public/CommercialProperty/AgreementCopy/'.$commercialProperty->agreement_file);
        }

        if (!empty($commercialProperty->rent_agreement_file) && Storage::exists('public/CommercialProperty/RentAgreementFile/'.$commercialProperty->rent_agreement_file)) {
         Storage::delete('public/CommercialProperty/RentAgreementFile/'.$commercialProperty->rent_agreement_file);
        }

        if (!empty($commercialProperty->share_certificate_file) && Storage::exists('public/CommercialProperty/ShareCertificateFile/'.$commercialProperty->share_certificate_file)) {
         Storage::delete('public/CommercialProperty/ShareCertificateFile/'.$commercialProperty->share_certificate_file);
        }

        if (!empty($commercialProperty->lease_document_file) && Storage::exists('public/CommercialProperty/LeaseDocumentFile/'.$commercialProperty->lease_document_file)) {
         Storage::delete('public/CommercialProperty/LeaseDocumentFile/'.$commercialProperty->lease_document_file);
        }

        $commercialProperty->delete();

        return $this->sendResponse([], 'Commercial Property deleted successfully');
    }
}