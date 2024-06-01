<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function CreateProfile(Request $request)
    {   $aadharFileNameToStore =null;
      $panFileNameToStore = null;
      $paasportFileNameToStore = null;
      $dlFileNameToStore = null;
      $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'fullLegalName'=>'required|string',
            'gender' => 'required',
            'dob' => 'required',
            'nationality' => 'required|string',
            'countryOfResidence' => 'required|string',
            'religion' => 'required|string',
            'maritalStatus' => 'nullable|string',
            'marriedUnderSpecialAct' => 'required|string',

            //  address details
            'correspondenceEmail' => 'required|string|email|max:255|unique:profiles',
            'permanentHouseFlatNo' => 'required|string|max:255',
            'permanentAddressLine1' => 'required|string|max:255',
            'permanentAddressLine2' => 'nullable|string|max:255',
            'permanentPincode' => 'required|string|max:10',
            'permanentCity' => 'required|string|max:255',
            'permanentState' => 'nullable|string|max:255',
            'permanentCountry' => 'nullable|string|max:255',
            //'current_address' => 'boolean',  // drop
            'currentHouseFlatNo' => 'required|string|max:255',
            'currentAddressLine1' => 'required|string|max:255',
            'currentAddressLine2' => 'nullable|string|max:255',
            'currentPincode' => 'required|string|max:10',
            'currentCity' => 'required|string|max:255',
            'currentState' => 'nullable|string|max:255',
            'currentCountry' => 'nullable|string|max:255',

            // KYC details  adhar file and pan mandatory  required_if
           // 'identification_details' => 'required',
            'adharNumber' => 'sometimes|string|max:12',
            'aadharName' => 'nullable|string|max:255',
            ///'adharFile' => 'nullable|mimes:jpeg,png,pdf|file|max:2048',
            'adharFile' => 'nullable|max:2048',
            'panNumber' => 'sometimes|string|max:10',
            'panName' => 'nullable|string|max:255',
            'panFile' => 'sometimes|file|max:2048',
            'passportNumber' => 'nullable|string|max:15',
            'passportName' => 'nullable|string|max:255',
            'passportExpiryDate' => 'nullable|date',
            'passportPlaceOfIssue' => 'nullable|string|max:255',
            'passportFile' => 'nullable|file|max:2048',
            'drivingLicenceNumber' => 'nullable|string|max:20',
            'drivingLicenceName' => 'nullable|string|max:255',
            'drivingLicenceExpiryDate' => 'nullable|date',
            'drivingLicencePlaceOfIssue' => 'nullable|string|max:255',
            'drivingLicenceFile' => 'nullable|file|max:2048',

      ]);


      if($validator->fails()){
           return response()->json(['success'=>false, 'message'=>$validator->errors()], 401);
      }


      //  aadhar card file uploads
      if($request->hasFile('adharFile')){
        //get file name with extention

        $aadharFileNameWithExt = $request->file('adharFile')->getClientOriginalImage();
        //get just filename
        $aadharFilename = pathinfo($aadharFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $aadharExtention = $request->file('adharFile')->getClientOriginalExtention();

        $aadharFileNameToStore = $aadharFilename.'_'.time().'.'.$aadharExtention;
        //upload image
        $path = $request->file('adharFile')->storeAs('public/adharFiles', $aadharFileNameToStore);

      }

            //  pan card file uploads
      if($request->hasFile('panFile')){
        //get file name with extention

        $panFileNameWithExt = $request->file('panFile')->getClientOriginalImage();
        //get just filename
        $panFilename = pathinfo($panFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $panExtention = $request->file('panFile')->getClientOriginalExtention();

        $panFileNameToStore = $panFilename.'_'.time().'.'.$panExtention;
        //upload image
        $path = $request->file('panFile')->storeAs('public/panFiles', $panFileNameToStore);

      }


       //  passport file uploads
       if($request->hasFile('passportFile')){
        //get file name with extention

        $paasportFileNameWithExt = $request->file('passportFile')->getClientOriginalImage();
        //get just filename
        $paasportFilename = pathinfo($paasportFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $paasportExtention = $request->file('passportFile')->getClientOriginalExtention();

        $paasportFileNameToStore = $paasportFilename.'_'.time().'.'.$paasportExtention;
        //upload image
        $path = $request->file('passportFile')->storeAs('public/passportFile', $paasportFileNameToStore);

      }


       //  dl file uploads
       if($request->hasFile('drivingLicenceFile')){
        //get file name with extention

        $dlFileNameWithExt = $request->file('drivingLicenceFile')->getClientOriginalImage();
        //get just filename
        $dlFilename = pathinfo($dlFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $dlExtention = $request->file('drivingLicenceFile')->getClientOriginalExtention();

        $dlFileNameToStore = $dlFilename.'_'.time().'.'.$dlExtention;
        //upload image
        $path = $request->file('drivingLicenceFile')->storeAs('public/drivingLicenceFile', $dlFileNameToStore);

      }
      

    //  $profile = Profile::create($request->all()); //changes need in this line
    $fillableAttributes = $request->only([
      'user_id',
      'fullLegalName',
      'gender',
      'dob',
      'nationality',
      'countryOfResidence',
      'religion',
      'maritalStatus',
      'marriedUnderSpecialAct',
      'correspondenceEmail',
      'permanentHouseFlatNo',
      'permanentAddressLine1',
      'permanentAddressLine2',
      'permanentPincode',
      'permanentCity',
      'permanentState',
      'permanentCountry',
     // 'current_address',
      'currentHouseFlatNo',
      'currentAddressLine1',
      'currentAddressLine2',
      'currentPincode',
      'currentCity',
      'currentState',
      'currentCountry',
     // 'identification_details',
      'adharNumber',
      'aadharName',
      'panNumber',
      'panName',
      'passportNumber',
      'passportName',
      'passportExpiryDate',
      'placeOfIssue',
      'drivingLicenceNumber',
      'drivingLicenceName',
      'drivingLicenceExpiryDate',
      'drivingLicencePlaceOfIssue',
  ]);

    
   // Manually set other attributes
   $additionalAttributes = [
    'adharFile' => $aadharFileNameToStore,
    'panFile' => $panFileNameToStore,
    'passportFile' => $paasportFileNameToStore,
    'drivingLicenceFile' => $dlFileNameToStore,
];


  // Merge both sets of attributes
  $attributes = array_merge($fillableAttributes, $additionalAttributes);

  // Create user
  $profile = Profile::create($attributes);


  return response()->json(['success'=>true, 'message'=> 'Profie details added successfully', 'profile'=>$profile],201);


    }




}
