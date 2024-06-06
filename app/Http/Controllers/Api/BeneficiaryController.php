<?php

namespace App\Http\Controllers\API;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BeneficiaryResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;

class BeneficiaryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $beneficiary = Beneficiary::all();
        $profile = Profile::all();
        if (is_null($beneficiary)) {
            return $this->sendError('beneficiaries not added.', ['error'=>'Beneficiaries not added']);
        }
        return $this->sendResponse(['Beneficiaries'=>BeneficiaryResource::collection($beneficiary)], "Beneficiaries retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeneficiaryRequest $request): JsonResponse
    {    $user = Auth::user();
        $beneficiary = new Beneficiary();
        $beneficiary->profile_id = $user->profile->id;
        $beneficiary->full_legal_name = $request->input('full_legal_name');
        $beneficiary->relationship = $request->input('relationship');
        $beneficiary->gender = $request->input('gender');
        $beneficiary->dob = $request->input('dob');
        $beneficiary->guardian_full_legal_name = $request->input('guardian_full_legal_name');
        $beneficiary->guardian_mobile_number = $request->input('guardian_mobile_number');
        $beneficiary->guardian_email = $request->input('guardian_email');
        $beneficiary->guardian_city = $request->input('guardian_city');
        $beneficiary->guardian_state = $request->input('guardian_state');
        $beneficiary->adhar_number = $request->input('adhar_number');
        $beneficiary->pan_number = $request->input('pan_number');
        $beneficiary->passport_number = $request->input('passport_number');
        $beneficiary->driving_licence_number = $request->input('driving_licence_number');
        $beneficiary->religion = $request->input('religion');
        $beneficiary->nationality = $request->input('nationality');
        $beneficiary->house_flat_no = $request->input('house_flat_no');
        $beneficiary->address_line_1 = $request->input('address_line_1');
        $beneficiary->address_line_2 = $request->input('address_line_2');
        $beneficiary->pincode = $request->input('pincode');
        $beneficiary->beneficiary_city = $request->input('beneficiary_city');
        $beneficiary->beneficiary_state = $request->input('beneficiary_state');
        $beneficiary->beneficiary_country = $request->input('beneficiary_country');
        $beneficiary->charity_name = $request->input('charity_name');
        $beneficiary->charity_address_1 = $request->input('charity_address_1');
        $beneficiary->charity_address_2 = $request->input('charity_address_2');
        $beneficiary->charity_city = $request->input('charity_city');
        $beneficiary->charity_state = $request->input('charity_state');
        $beneficiary->charity_phone_number = $request->input('charity_phone_number');
        $beneficiary->charity_email = $request->input('charity_email');
        $beneficiary->charity_contact_person = $request->input('charity_contact_person');
        $beneficiary->charity_website = $request->input('charity_website');
        $beneficiary->charity_specific_instruction = $request->input('charity_specific_instruction');
        $beneficiary->save();  //data saved

        return $this->sendResponse(['Beneficiary'=>new BeneficiaryResource($beneficiary)], 'Beneficiary created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $beneficiary = Beneficiary::find($id);

        if(is_null($beneficiary)){
            return $this->sendError('Beneficiary Not Found',['error'=>'beneficiary not found']);
        }
        return $this->sendResponse(['Beneficiary'=>new BeneficiaryResource($beneficiary)], 'Beneficiary retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary): JsonResponse
    {    $user = Auth::user();
         if($user->profile->id !== $beneficiary->profile_id){
            return $this->sendError('Beneficiary not found', ['error'=>'Beneficiary not found']);
          }
        $beneficiary->full_legal_name = $request->input('full_legal_name');
        $beneficiary->relationship = $request->input('relationship');
        $beneficiary->gender = $request->input('gender');
        $beneficiary->dob = $request->input('dob');
        $beneficiary->guardian_full_legal_name = $request->input('guardian_full_legal_name');
        $beneficiary->guardian_mobile_number = $request->input('guardian_mobile_number');
        $beneficiary->guardian_email = $request->input('guardian_email');
        $beneficiary->guardian_city = $request->input('guardian_city');
        $beneficiary->guardian_state = $request->input('guardian_state');
        $beneficiary->adhar_number = $request->input('adhar_number');
        $beneficiary->pan_number = $request->input('pan_number');
        $beneficiary->passport_number = $request->input('passport_number');
        $beneficiary->driving_licence_number = $request->input('driving_licence_number');
        $beneficiary->religion = $request->input('religion');
        $beneficiary->nationality = $request->input('nationality');
        $beneficiary->house_flat_no = $request->input('house_flat_no');
        $beneficiary->address_line_1 = $request->input('address_line_1');
        $beneficiary->address_line_2 = $request->input('address_line_2');
        $beneficiary->pincode = $request->input('pincode');
        $beneficiary->beneficiary_city = $request->input('beneficiary_city');
        $beneficiary->beneficiary_state = $request->input('beneficiary_state');
        $beneficiary->beneficiary_country = $request->input('beneficiary_country');
        $beneficiary->charity_name = $request->input('charity_name');
        $beneficiary->charity_address_1 = $request->input('charity_address_1');
        $beneficiary->charity_address_2 = $request->input('charity_address_2');
        $beneficiary->charity_city = $request->input('charity_city');
        $beneficiary->charity_state = $request->input('charity_state');
        $beneficiary->charity_phone_number = $request->input('charity_phone_number');
        $beneficiary->charity_email = $request->input('charity_email');
        $beneficiary->charity_contact_person = $request->input('charity_contact_person');
        $beneficiary->charity_website = $request->input('charity_website');
        $beneficiary->charity_specific_instruction = $request->input('charity_specific_instruction');
        $beneficiary->save();
 
        return $this->sendResponse(['Beneficiary'=>new BeneficiaryResource($beneficiary)], "Beneficiary updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {          
        $beneficiary = Beneficiary::find($id);
        
        if (!$beneficiary) {
            return $this->sendError('Beneficiary not found', ['error' => 'Beneficiary not found'], 404);
        }

        $user = Auth::user();
        if($user->profile->id !== $beneficiary->profile_id){
           return $this->sendError('Beneficiary not found', ['error'=>'Beneficiary not found']);
         }

        $beneficiary->delete();
        return $this->sendResponse([],'Beneficiary deleted successfully');
    }
}
