<?php

namespace App\Http\Controllers\API;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $profile = Profile::all();
        return $this->sendResponse(ProfileResource::collection($profile), 'profiles retrived successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profile = new Profile();
        $profile->full_legal_name = $request->input('full_legal_name');
        $profile->gender = $request->input('gender');
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('country_of_residence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('marital_status');
        $profile->married_under_special_act = $request->input('married_under_special_act');
        $profile->correspondence_email = $request->input('correspondence_email');
        $profile->permanent_house_flat_no = $request->input('permanent_house_flat_no');
        $profile->permanent_address_line_1 = $request->input('permanent_address_line_1');
        $profile->permanent_address_line_2 = $request->input('permanent_address_line_2');
        $profile->permanent_pincode = $request->input('permanent_pincode');
        $profile->permanent_city = $request->input('permanent_city');
        $profile->permanent_state = $request->input('permanent_state');
        $profile->permanent_country = $request->input('permanent_country');
        $profile->current_house_flat_no = $request->input('current_house_flat_no');
        $profile->current_address_line_1 = $request->input('current_address_line_1');
        $profile->current_address_line_2 = $request->input('current_address_line_2');
        $profile->current_pincode = $request->input('current_pincode');
        $profile->current_city = $request->input('current_city');
        $profile->current_state = $request->input('current_state');
        $profile->current_country = $request->input('current_country');
        $profile->adhar_number = $request->input('adhar_number');
        $profile->adhar_name = $request->input('adhar_name');
        $profile->adhar_file = $request->file('adhar_file');
        $profile->pan_number = $request->input('pan_number');
        $profile->pan_name = $request->input('pan_name');
        $profile->pan_file = $request->file('pan_file');
        $profile->passport_number = $request->input('passport_number');
        $profile->passport_name = $request->input('passport_name');
        $profile->passport_expiry_date = $request->input('passport_expiry_date');
        $profile->passport_place_of_issue = $request->input('passport_place_of_issue');
        $profile->passport_file = $request->file('passport_file');
        $profile->driving_licence_number = $request->input('driving_licence_number');
        $profile->driving_licence_name = $request->input('driving_licence_name');
        $profile->driving_licence_expiry_date = $request->input('driving_licence_expiry_date');
        $profile->driving_licence_place_of_issue = $request->input('driving_licence_place_of_issue');
        $profile->driving_licence_file = $request->file('driving_licence_file');
        $profile->save();

        return $this->sendResponse(new ProductResource($profile), 'Profile created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.');
        }
        return $this->sendResponse(new ProfileResource($profile), 'Profile retrieved successfully.');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->full_legal_name = $request->input('full_legal_name');
        $profile->gender = $request->input('gender');
        $profile->dob = $request->input('dob');
        $profile->nationality = $request->input('nationality');
        $profile->country_of_residence = $request->input('country_of_residence');
        $profile->religion = $request->input('religion');
        $profile->marital_status = $request->input('marital_status');
        $profile->married_under_special_act = $request->input('married_under_special_act');
        $profile->correspondence_email = $request->input('correspondence_email');
        $profile->permanent_house_flat_no = $request->input('permanent_house_flat_no');
        $profile->permanent_address_line_1 = $request->input('permanent_address_line_1');
        $profile->permanent_address_line_2 = $request->input('permanent_address_line_2');
        $profile->permanent_pincode = $request->input('permanent_pincode');
        $profile->permanent_city = $request->input('permanent_city');
        $profile->permanent_state = $request->input('permanent_state');
        $profile->permanent_country = $request->input('permanent_country');
        $profile->current_house_flat_no = $request->input('current_house_flat_no');
        $profile->current_address_line_1 = $request->input('current_address_line_1');
        $profile->current_address_line_2 = $request->input('current_address_line_2');
        $profile->current_pincode = $request->input('current_pincode');
        $profile->current_city = $request->input('current_city');
        $profile->current_state = $request->input('current_state');
        $profile->current_country = $request->input('current_country');
        $profile->adhar_number = $request->input('adhar_number');
        $profile->adhar_name = $request->input('adhar_name');
        $profile->adhar_file = $request->file('adhar_file');
        $profile->pan_number = $request->input('pan_number');
        $profile->pan_name = $request->input('pan_name');
        $profile->pan_file = $request->file('pan_file');
        $profile->passport_number = $request->input('passport_number');
        $profile->passport_name = $request->input('passport_name');
        $profile->passport_expiry_date = $request->input('passport_expiry_date');
        $profile->passport_place_of_issue = $request->input('passport_place_of_issue');
        $profile->passport_file = $request->file('passport_file');
        $profile->driving_licence_number = $request->input('driving_licence_number');
        $profile->driving_licence_name = $request->input('driving_licence_name');
        $profile->driving_licence_expiry_date = $request->input('driving_licence_expiry_date');
        $profile->driving_licence_place_of_issue = $request->input('driving_licence_place_of_issue');
        $profile->driving_licence_file = $request->file('driving_licence_file');
        $profile->save();

        return $this->sendResponse(new ProductResource($profile), 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
