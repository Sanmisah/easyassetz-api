<?php

namespace App\Http\Controllers\Api;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LandResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class LandController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $land = $user->profile->land()->get();
        return $this->sendResponse(['Land'=>LandResource::collection($land)], "Land details retrived successfully");
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
            $litigationPath = $request->file('litigationFile')->storeAs('public/litigationFile', $litigationFileNameToStore);
         }

        $user = Auth::user();
        $land = new Land();
        $land->profile_id = $user->profile->id;
        $land->property_type = $request->input('propertyType');
        $land->survey_number = $request->input('surveyNumber');
        $land->address = $request->input('address');
        $land->village_name = $request->input('villageName');
        $land->district = $request->input('district');
        $land->taluka = $request->input('taluka');
        $land->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
        $land->ownership_type = $request->input('ownershipType');
        $land->first_holders_name = $request->input('firstHoldersName');
        $land->first_holders_relation = $request->input('firstHoldersRelation');
        $land->first_holders_pan = $request->input('firstHoldersPan');
        $land->first_holders_aadhar = $request->input('firstHoldersAadhar');
        $land->joint_holders_name = $request->input('jointHoldersName');
        $land->joint_holders_relation = $request->input('jointHoldersRelation');
        $land->joint_holders_pan = $request->input('jointHoldersPan');
        $land->joint_holders_aadhar = $request->input('jointHoldersAadhar');
        $land->any_loan_litigation = $request->input('anyLoanLitigation');
        if($request->hasFile('litigationFile')){
            $land->image = $litigationFileNameToStore;
         }
        $land->name = $request->input('name');
        $land->mobile = $request->input('mobile');
        $land->email = $request->input('email');
        $land->save();

        return $this->sendResponse(['Land'=> new LandResource($land)], 'Land Details Updated successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = Auth::user();
        $land = Land::find($id);
        if(!$land){
            return $this->sendError('Land not found', ['error'=>'Land not found']);
        } 

        if($user->profile->id !== $land->profile_id){
            return $this->sendError('Unauthorize', ['error'=>'you are not allowed to access view this Land details']);
        }

        return $this->sendResponse(['Land'=> new LandResource($land)], 'Land details retrived successfully');
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
            $litigationPath = $request->file('litigationFile')->storeAs('public/DigitalAsset/LitigationFiles', $litigationFileNameToStore);
         }

        if($request->hasFile('leaseDocumentFile')){
            $ldfFileNameWithExtention = $request->file('leaseDocumentFile')->getClientOriginalName();
            $ldFilename = pathinfo($ldFileNameWithExtention, PATHINFO_FILENAME);
            $ldExtention = $request->file('leaseDocumentFile')->getClientOriginalExtension();
            $ldFileNameToStore = $ldFilename.'_'.time().'.'.$ldExtention;
            $ldPath = $request->file('leaseDocumentFile')->storeAs('public/DigitalAsset/LeaseDocumentFiles', $ldFileNameToStore);
         }

        if($request->hasFile('agreementFile')){
            $agreementFileNameWithExtention = $request->file('agreementFile')->getClientOriginalName();
            $agreementFilename = pathinfo($agreementFileNameWithExtention, PATHINFO_FILENAME);
            $agreementExtention = $request->file('agreementFile')->getClientOriginalExtension();
            $agreementFileNameToStore = $agreementFilename.'_'.time().'.'.$agreementExtention;
            $agreementPath = $request->file('agreementFile')->storeAs('public/DigitalAsset/AgreementFiles', $agreementFileNameToStore);
         }

         if($request->hasFile('extractFile')){
            $extractFileNameWithExtention = $request->file('extractFile')->getClientOriginalName();
            $extractFilename = pathinfo($extractFileNameWithExtention, PATHINFO_FILENAME);
            $extractExtention = $request->file('extractFile')->getClientOriginalExtension();
            $extractFileNameToStore = $extractFilename.'_'.time().'.'.$extractExtention;
            $extractPath = $request->file('extractFile')->storeAs('public/DigitalAsset/Extract_7_12', $extractFileNameToStore);
         }


        $land = Land::find($id);
        if(!$land){
            return $this->sendError('Land Not Found',['error'=>'Land not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $land->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Land']);
         }

         $land->property_type = $request->input('propertyType');
         $land->survey_number = $request->input('surveyNumber');
         $land->address = $request->input('address');
         $land->village_name = $request->input('villageName');
         $land->district = $request->input('district');
         $land->taluka = $request->input('taluka');
         $land->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
         $land->ownership_type = $request->input('ownershipType');
         $land->first_holders_name = $request->input('firstHoldersName');
         $land->first_holders_relation = $request->input('firstHoldersRelation');
         $land->first_holders_pan = $request->input('firstHoldersPan');
         $land->first_holders_aadhar = $request->input('firstHoldersAadhar');
         $land->joint_holders_name = $request->input('jointHoldersName');
         $land->joint_holders_relation = $request->input('jointHoldersRelation');
         $land->joint_holders_pan = $request->input('jointHoldersPan');
         $land->joint_holders_aadhar = $request->input('jointHoldersAadhar');
         $land->any_loan_litigation = $request->input('anyLoanLitigation');
         if($request->hasFile('litigationFile')){
             $land->litigation_file = $litigationFileNameToStore;
          }
          if($request->hasFile('leaseDocumentFile')){
            $land->lease_document_file = $ldFileNameToStore;
         }
         if($request->hasFile('agreementFile')){
            $land->agreement_file = $agreementFileNameToStore;
         }
         if($request->hasFile('extractFile')){
            $land->extract_7_12 = $extractFileNameToStore;
         }
         $land->name = $request->input('name');
         $land->mobile = $request->input('mobile');
         $land->email = $request->input('email');
         $land->save();

         return $this->sendResponse(['Land'=> new LandResource($land)], 'Land details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $land = Land::find($id);
        if(!$land){
            return $this->sendError('Land details not found', ['error'=>'Land details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $land->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Land Details']);
        }
        $land->delete();

        return $this->sendResponse([], 'Land details deleted successfully');
    }
}
