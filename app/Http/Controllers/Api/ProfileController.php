<?php

namespace App\Http\Controllers\Api;

use Log;
use File;
use Response;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Storage;
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
         //write a code for deleting image
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
    public function update(Request $request, string $id)
    {  
        $profile = Profile::find($id); 
        if(!$profile){
            return $this->sendError('Profile Not Found', ['error'=>'Profile not found']);
        }
        $user = Auth::user();
        if($user->id !== $profile->user_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this profile.']);
        }

        if($request->hasFile('aadharFile')){
            if(!empty($profile->adhar_file) && Storage::exists('public/profiles/aadharFile/'.$profile->adhar_file)) {
                Storage::delete('public/profiles/aadharFile/'.$profile->adhar_file);
            }
            $aadharfileNameWithExt = $request->file('aadharFile')->getClientOriginalName();
            $aadharfilename = pathinfo($aadharfileNameWithExt, PATHINFO_FILENAME);
            $aadharExtention = $request->file('aadharFile')->getClientOriginalExtension();
            $aadharFileNameToStore = $aadharfilename.'_'.time().'.'.$aadharExtention;
            $aadharPath = $request->file('aadharFile')->storeAs('public/profiles/aadharFile', $aadharFileNameToStore);
         }

         if($request->hasFile('panFile')){
            if(!empty($profile->pan_file) && Storage::exists('public/profiles/panFiles/'.$profile->pan_file)) {
                Storage::delete('public/profiles/panFiles/'.$profile->pan_file);
            }
            $panFileNameWithExt = $request->file('panFile')->getClientOriginalName();
            $panFilename = pathinfo($panFileNameWithExt, PATHINFO_FILENAME);
            $panExtention = $request->file('panFile')->getClientOriginalExtension();
            $panFileNameToStore = $panFilename.'_'.time().'.'.$panExtention;
            $panPath = $request->file('panFile')->storeAs('public/profiles/panFiles', $panFileNameToStore);
         }

         if($request->hasFile('passportFile')){
            if(!empty($profile->passport_file) && Storage::exists('public/profiles/passportFiles/'.$profile->passport_file)) {
                Storage::delete('public/profiles/passportFiles/'.$profile->passport_file);
            }
            $passportFileNameWithExt = $request->file('passportFile')->getClientOriginalName();
            $passportFilename = pathinfo($passportFileNameWithExt, PATHINFO_FILENAME);
            $passportExtention = $request->file('passportFile')->getClientOriginalExtension();
            $passportFileNameToStore = $passportFilename.'_'.time().'.'.$passportExtention;
            $passportPath = $request->file('passportFile')->storeAs('public/profiles/passportFiles', $passportFileNameToStore);
         }

         if($request->hasFile('drivingFile')){
            if(!empty($profile->driving_licence_file) && Storage::exists('public/profiles/drivingLicenceFiles/'.$profile->driving_licence_file)) {
                Storage::delete('public/profiles/drivingLicenceFiles/'.$profile->driving_licence_file);
            }
            $drivingFileNameWithExtention = $request->file('drivingFile')->getClientOriginalName();
            $drivingFilename = pathinfo($drivingFileNameWithExtention, PATHINFO_FILENAME);
            $drivingExtention = $request->file('drivingFile')->getClientOriginalExtension();
            $drivingFileNameToStore = $drivingFilename.'_'.time().'.'.$drivingExtention;
            $drivingPath = $request->file('drivingFile')->storeAs('public/profiles/drivingLicenceFiles', $drivingFileNameToStore);
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
        $profile->adhar_number = $request->input('aadharNumber');
        $profile->adhar_name = $request->input('aadharName');
        if($request->hasFile('aadharFile')){
             $profile->adhar_file = $aadharFileNameToStore;
        }
        $profile->pan_number = $request->input('panNumber');
        $profile->pan_name = $request->input('panName');
        if($request->hasFile('panFile')){
            $profile->pan_file =$panFileNameToStore;
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
        if($request->hasFile('drivingFile')){
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

    // public function showAadharFiles(string $files){
    //      $path = storage_path('app/public/profiles/aadharFile/'.$files);

    //      if(!file_exists($path)){
    //         abort(404);
    //      }

    //      $file = File::get($path);
    //      $type = \File::mimeType($path);

    //      $response = Response::make($file, 200);
    //      $response->header("Content-Type", $type);
    //      $response->header('Content-Disposition', 'inline; filename="' . $files . '"');

    //      return $response;
    // }
//     public function showPanFiles(string $files){
//          $path = storage_path('app/public/profiles/panFiles/'.$files);

//          if(!file_exists($path)){
//             abort(404);
//          }

//          $file = File::get($path);
//          $type = \File::mimeType($path);

//          $response = Response::make($file, 200);
//          $response->header("Content-Type", $type);
//          $response->header('Content-Disposition', 'inline; filename="' . $files . '"');

//          return $response;

//     }

//     public function showDrivingLicenceFiles(string $files){
//         $path = storage_path('app/public/profiles/drivingLicenceFiles/'.$files);

//         if(!file_exists($path)){
//            abort(404);
//         }

//         $file = File::get($path);
//         $type = \File::mimeType($path);

//         $response = Response::make($file, 200);
//         $response->header("Content-Type", $type);
//         $response->header('Content-Disposition', 'inline; filename="' . $files . '"');

//         return $response;

//    }


   public function showFiles(string $files){

    $location = ['app/public/profiles/aadharFile/','app/public/profiles/panFiles/','app/public/profiles/passportFiles/','app/public/profiles/drivingLicenceFiles/'];

    foreach($location as $loc){
        $path = storage_path($loc.$files);
        if(file_exists($path)){
            break;
        }
    }
    // $path = storage_path('app/public/profiles/passportFiles/'.$files);
   
    // if(!file_exists($path)){
    //    abort(404);
    // }

    $file = File::get($path);
    $type = \File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    $response->header('Content-Disposition', 'inline; filename="' . $files . '"');

    return $response;

}


// public function showFiles(string $files){
//     $decodedFilename = urldecode($files);
    
//     // Construct the full path
//     $path = storage_path('app/' . $decodedFilename);
    
//     // Check if the file exists
//     if (!File::exists($path)) {
//         abort(404);
//     }
    
//     // Get file content and MIME type
//     $fileName = basename($path);
//     $file = File::get($path);
//     $type = File::mimeType($path);
    
//     // Create the response with headers
//     $response = Response::make($file, 200);
//     $response->header("Content-Type", $type);
//     $response->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    
//     return $response;
// }


  

}