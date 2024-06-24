<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Controllers\Api\BaseController;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {  
        if($request->hasFile('aadharFile')){
            $aadharfileNameWithExt = $request->file('aadharFile')->getClientOriginalName();
            $aadharfilename = pathinfo($aadharfileNameWithExt, PATHINFO_FILENAME);
            $aadharExtention = $request->file('aadharFile')->getClientOriginalExtension();
            $aadharFileNameToStore = $aadharfilename.'_'.time().'.'.$aadharExtention;
            $aadharPath = $request->file('aadharFile')->storeAs('public/profiles/aadharFile', $aadharFileNameToStore);
         }

         if($request->hasFile('panFile')){
            $panFileNameWithExt = $request->file('panFile')->getClientOriginalName();
            $panFilename = pathinfo($panFileNameWithExt, PATHINFO_FILENAME);
            $panExtention = $request->file('panFile')->getClientOriginalExtension();
            $panFileNameToStore = $panFilename.'_'.time().'.'.$panExtention;
            $panPath = $request->file('panFile')->storeAs('public/profiles/panFiles', $panFileNameToStore);
         }

         if($request->hasFile('passportFile')){
            $passportFileNameWithExt = $request->file('passportFile')->getClientOriginalName();
            $passportFilename = pathinfo($passportFileNameWithExt, PATHINFO_FILENAME);
            $passportExtention = $request->file('passportFile')->getClientOriginalExtension();
            $passportFileNameToStore = $passportFilename.'_'.time().'.'.$passportExtention;
            $passportPath = $request->file('passportFile')->storeAs('public/profiles/passportFiles', $passportFileNameToStore);
         }

         if($request->hasFile('drivingLicenceFile')){
            $drivingFileNameWithExtention = $request->file('drivingLicenceFile')->getClientOriginalName();
            $drivingFilename = pathinfo($drivingFileNameWithExtention, PATHINFO_FILENAME);
            $drivingExtention = $request->file('drivingLicenceFile')->getClientOriginalExtension();
            $drivingFileNameToStore = $drivingFilename.'_'.time().'.'.$drivingExtention;
            $drivingPath = $request->file('drivingLicenceFile')->storeAs('public/profiles/drivingLicenceFiles', $drivingFileNameToStore);
         }
        
        $user = Auth::user();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->full_legal_name = $request->input('fullLegalName');
        $profile->gender = $request->input('gender');
        // $formatedDate = $request->input('dob');
        // $carbonDate = Carbon::parse($formattedDate);
        // $iso8601Date = $carbonDate->toIso8601String();
        // $profile->dob = $iso8601Date;
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('countryOfResidence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('maritalStatus');
        $profile->married_under_special_act = $request->input('marriedUnderSpecialAct');
        $profile->correspondence_email = $request->input('correspondenceEmail');
        $profile->permanent_house_flat_no = $request->input('permanentHouseFlatNo');
        $profile->permanent_address_line_1 = $request->input('permanentAddressLine1');
        $profile->permanent_address_line_2 = $request->input('permanentAddressLine2');
        $profile->permanent_pincode = $request->input('permanentPincode');
        $profile->permanent_city = $request->input('permanentCity');
        $profile->permanent_state = $request->input('permanentState');
        $profile->permanent_country = $request->input('permanentCountry');
        $profile->current_house_flat_no = $request->input('currentHouseFlatNo');
        $profile->current_address_line_1 = $request->input('currentAddressLine1');
        $profile->current_address_line_2 = $request->input('currentAddressLine2');
        $profile->current_pincode = $request->input('currentPincode');
        $profile->current_city = $request->input('currentCity');
        $profile->current_state = $request->input('currentState');
        $profile->current_country = $request->input('currentCountry');
        $profile->adhar_number = $request->input('adharNumber');
        $profile->adhar_name = $request->input('adharName');
        if($request->hasFile('aadharFile')){
            $profile->adhar_file = $aadharFileNameToStore;
        }
        $profile->pan_number = $request->input('panNumber');
        $profile->pan_name = $request->input('panName');
        if($request->hasFile('panFile')){
            $profile->pan_file = $panFileNameToStore;
        }
        $profile->passport_number = $request->input('passportNumber');
        $profile->passport_name = $request->input('passportName');
        $profile->passport_expiry_date = $request->input('passportExpiryDate');
        $profile->passport_place_of_issue = $request->input('passportPlaceOfIssue');
        if($request->hasFile('passportFile')){
            $profile->passport_file = $passportFileNameToStore;
        }
        $profile->driving_licence_number = $request->input('drivingLicenceNumber');
        $profile->driving_licence_name = $request->input('drivingLicenceName');
        $profile->driving_licence_expiry_date = $request->input('drivingLicenceExpiryDate');
        $profile->driving_licence_place_of_issue = $request->input('drivingLicencePlaceOfIsue');
        if($request->hasFile('drivingLicenceFile')){
            $profile->driving_licence_file = $drivingFileNameToStore;
        }
        $profile->save();

        return $this->sendResponse(['profile'=>new ProfileResource($profile)], 'Profile created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return $this->sendError('Profile not found.', ['error'=>'Profile not found']);
        }
        $user = Auth::user();
        if($user->id !== $profile->user_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this profile.']);
        }
        return $this->sendResponse(['profile'=>new ProfileResource($profile)], 'Profile retrieved successfully.');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, string $id)
    { 
        if($request->hasFile('aadharFile')){
            $aadharfileNameWithExt = $request->file('aadharFile')->getClientOriginalName();
            $aadharfilename = pathinfo($aadharfileNameWithExt, PATHINFO_FILENAME);
            $aadharExtention = $request->file('aadharFile')->getClientOriginalExtension();
            $aadharFileNameToStore = $aadharfilename.'_'.time().'.'.$aadharExtention;
            $aadharPath = $request->file('aadharFile')->storeAs('public/profiles/aadharFile', $aadharFileNameToStore);
         }

         if($request->hasFile('panFile')){
            $panFileNameWithExt = $request->file('panFile')->getClientOriginalName();
            $panFilename = pathinfo($panFileNameWithExt, PATHINFO_FILENAME);
            $panExtention = $request->file('panFile')->getClientOriginalExtension();
            $panFileNameToStore = $panFilename.'_'.time().'.'.$panExtention;
            $panPath = $request->file('panFile')->storeAs('public/profiles/panFiles', $panFileNameToStore);
         }

         if($request->hasFile('passportFile')){
            $passportFileNameWithExt = $request->file('passportFile')->getClientOriginalName();
            $passportFilename = pathinfo($passportFileNameWithExt, PATHINFO_FILENAME);
            $passportExtention = $request->file('passportFile')->getClientOriginalExtension();
            $passportFileNameToStore = $passportFilename.'_'.time().'.'.$passportExtention;
            $passportPath = $request->file('passportFile')->storeAs('public/profiles/passportFiles', $passportFileNameToStore);
         }

         if($request->hasFile('drivingLicenceFile')){
            $drivingFileNameWithExtention = $request->file('drivingLicenceFile')->getClientOriginalName();
            $drivingFilename = pathinfo($drivingFileNameWithExtention, PATHINFO_FILENAME);
            $drivingExtention = $request->file('drivingLicenceFile')->getClientOriginalExtension();
            $drivingFileNameToStore = $drivingFilename.'_'.time().'.'.$drivingExtention;
            $drivingPath = $request->file('drivingLicenceFile')->storeAs('public/profiles/drivingLicenceFiles', $drivingFileNameToStore);
         }

        $profile = Profile::find($id); 
        if(!$profile){
            return $this->sendError('Profile Not Found', ['error'=>'Profile not found']);
        }
        $user = Auth::user();
        if($user->id !== $profile->user_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this profile.']);
        }
        $profile->full_legal_name = $request->input('fullLegalName');
        $profile->gender = $request->input('gender');
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('countryOfResidence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('maritalStatus');
        $profile->married_under_special_act = $request->input('marriedUnderSpecialAct');
        $profile->permanent_house_flat_no = $request->input('permanentHouseFlatNo');
        $profile->permanent_address_line_1 = $request->input('permanentAddressLine1');
        $profile->permanent_address_line_2 = $request->input('permanentAddressLine2');
        $profile->permanent_pincode = $request->input('permanentPincode');
        $profile->permanent_city = $request->input('permanentCity');
        $profile->permanent_state = $request->input('permanentState');
        $profile->permanent_country = $request->input('permanentCountry');
        $profile->current_house_flat_no = $request->input('currentHouseFlatNo');
        $profile->current_address_line_1 = $request->input('currentAddressLine1');
        $profile->current_address_line_2 = $request->input('currentAddressLine2');
        $profile->current_pincode = $request->input('currentPincode');
        $profile->current_city = $request->input('currentCity');
        $profile->current_state = $request->input('currentState');
        $profile->current_country = $request->input('currentCountry');
        $profile->adhar_number = $request->input('adharNumber');
        $profile->adhar_name = $request->input('adharName');
        if($request->hasFile('aadharFile')){
             $profile->adhar_file = $aadharFileNameToStore;
        }
        $profile->pan_number = $request->input('panNumber');
        $profile->pan_name = $request->input('panName');
        if($request->hasFile('panFile')){
            $profile->pan_file = $panFileNameToStore;
        }
        $profile->passport_number = $request->input('passportNumber');
        $profile->passport_name = $request->input('passportName');
        $profile->passport_expiry_date = $request->input('passportExpiryDate');
        $profile->passport_place_of_issue = $request->input('passportPlaceOfIssue');
        if($request->hasFile('passportFile')){
            $profile->passport_file = $passportFileNameToStore;
        }
        $profile->driving_licence_number = $request->input('drivingLicenceNumber');
        $profile->driving_licence_name = $request->input('drivingLicenceName');
        $profile->driving_licence_expiry_date = $request->input('drivingLicenceExpiryDate');
        $profile->driving_licence_place_of_issue = $request->input('drivingLicencePlaceOfIssue');
        if($request->hasFile('drivingLicenceFile')){
            $profile->driving_licence_file = $drivingFileNameToStore;
        }
        $profile->save();

        return $this->sendResponse(['profile'=>new ProfileResource($profile)], 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
