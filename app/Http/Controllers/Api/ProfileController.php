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
        $profile = Profile::all();
        return $this->sendResponse(['profile'=>ProfileResource::collection($profile)], 'profiles retrived successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {   $user = Auth::user();
        $profile = new Profile();  //add user_id and remove storing process of profile from register.
        $profile->user_id = $user->id;
        $profile->full_legal_name = $request->input('fullLegalName');
        $profile->gender = $request->input('gender');
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('countryOfResidence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('maritalStatus');
        $profile->married_under_special_act = $request->input('marriedUnderSpecialAct');
        $profile->correspondence_email = $request->input('correspondencEmail');
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
        $profile->adhar_file = $request->file('adharFile');
        $profile->pan_number = $request->input('panNumber');
        $profile->pan_name = $request->input('panName');
        $profile->pan_file = $request->file('panFile');
        $profile->passport_number = $request->input('passportNumber');
        $profile->passport_name = $request->input('passportName');
        $profile->passport_expiry_date = $request->input('passportExpiryDate');
        $profile->passport_place_of_issue = $request->input('passportPlaceOfIssue');
        $profile->passport_file = $request->file('passportFile');
        $profile->driving_licence_number = $request->input('drivingLicenceNumber');
        $profile->driving_licence_name = $request->input('drivingLicenceName');
        $profile->driving_licence_expiry_date = $request->input('drivingLicenceExpiryDate');
        $profile->driving_licence_place_of_issue = $request->input('drivingLicencePlaceOfIsue');
        $profile->driving_licence_file = $request->file('drivingLicenceFile');
        $profile->save();

        return $this->sendResponse(['profile'=>new ProfileResource($profile)], 'Profile created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', ['error'=>'Profile not found']);
        }
        return $this->sendResponse(['profile'=>new ProfileResource($profile)], 'Profile retrieved successfully.');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {   if(auth()->id !== $profile->user_id){
            return $this->sendError('Profile not found', ['error'=>'profile not found']);
          }
        $profile->full_legal_name = $request->input('fullLegalName');
        $profile->gender = $request->input('gender');
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('countryOfResidence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('maritalStatus');
        $profile->married_under_special_act = $request->input('marriedUnderSpecialAct');
        $profile->correspondence_email = $request->input('correspondencEmail');
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
        $profile->adhar_file = $request->file('adharFile');
        $profile->pan_number = $request->input('panNumber');
        $profile->pan_name = $request->input('panName');
        $profile->pan_file = $request->file('panFile');
        $profile->passport_number = $request->input('passportNumber');
        $profile->passport_name = $request->input('passportName');
        $profile->passport_expiry_date = $request->input('passportExpiryDate');
        $profile->passport_place_of_issue = $request->input('passportPlaceOfIssue');
        $profile->passport_file = $request->file('passportFile');
        $profile->driving_licence_number = $request->input('drivingLicenceNumber');
        $profile->driving_licence_name = $request->input('drivingLicenceName');
        $profile->driving_licence_expiry_date = $request->input('drivingLicenceExpiryDate');
        $profile->driving_licence_place_of_issue = $request->input('drivingLicencePlaceOfIssue');
        $profile->driving_licence_file = $request->file('drivingLicenceFile');
        $profile->save();

        return $this->sendResponse(['profile'=>new ProductResource($profile)], 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
