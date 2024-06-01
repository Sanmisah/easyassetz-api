<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function CreateProfile(Request $request)
    {  
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
            'currentHouseFlatNo' => 'required|string|max:255',
            'currentAddressLine1' => 'required|string|max:255',
            'currentAddressLine2' => 'nullable|string|max:255',
            'currentPincode' => 'required|string|max:10',
            'currentCity' => 'required|string|max:255',
            'currentState' => 'nullable|string|max:255',
            'currentCountry' => 'nullable|string|max:255',

            // KYC details  adhar file and pan mandatory  required_if
            'adharNumber' => 'sometimes|string|max:12',
            'adharName' => 'nullable|string|max:255',
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


      if ($request->hasFile('adharFile')) {
        // Get file name with extension
        $aadharFileNameWithExt = $request->file('adharFile')->getClientOriginalName();
        
        // Get just filename
        $aadharFilename = pathinfo($aadharFileNameWithExt, PATHINFO_FILENAME);
        
        // Get just extension
        $aadharExtension = $request->file('adharFile')->getClientOriginalExtension();
    
        // Concatenate filename with timestamp and extension to create a unique filename
        $aadharFileNameToStore = $aadharFilename.'_'.time().'.'.$aadharExtension;
        
        // Upload image to the specified path
        $path = $request->file('adharFile')->storeAs('public/adharFiles', $aadharFileNameToStore);
    }

   
    

            //  pan card file uploads
      if($request->hasFile('panFile')){
        //get file name with extention

        $panFileNameWithExt = $request->file('panFile')->getClientOriginalName();
        //get just filename
        $panFilename = pathinfo($panFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $panExtention = $request->file('panFile')->getClientOriginalExtension();

        $panFileNameToStore = $panFilename.'_'.time().'.'.$panExtention;
        //upload image
        $path = $request->file('panFile')->storeAs('public/panFiles', $panFileNameToStore);

      }


       //  passport file uploads
       if($request->hasFile('passportFile')){
        //get file name with extention

        $paasportFileNameWithExt = $request->file('passportFile')->getClientOriginalName();
        //get just filename
        $paasportFilename = pathinfo($paasportFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $paasportExtention = $request->file('passportFile')->getClientOriginalExtension();

        $paasportFileNameToStore = $paasportFilename.'_'.time().'.'.$paasportExtention;
        //upload image
        $path = $request->file('passportFile')->storeAs('public/passportFile', $paasportFileNameToStore);

      }


       //  dl file uploads
       if($request->hasFile('drivingLicenceFile')){
        //get file name with extention

        $dlFileNameWithExt = $request->file('drivingLicenceFile')->getClientOriginalName();
        //get just filename
        $dlFilename = pathinfo($dlFileNameWithExt, PATHINFO_FILENAME);
        //GET just ext
        $dlExtention = $request->file('drivingLicenceFile')->getClientOriginalExtension();

        $dlFileNameToStore = $dlFilename.'_'.time().'.'.$dlExtention;
        //upload image
        $path = $request->file('drivingLicenceFile')->storeAs('public/drivingLicenceFile', $dlFileNameToStore);

      }

 $profile =  Profile::create([
    'user_id' => $request->input('user_id'),
    'fullLegalName' => $request->input('fullLegalName'),
    'gender' => $request->input('gender'),
    'dob' => $request->input('dob'),
    'nationality' => $request->input('nationality'),
    'countryOfResidence' => $request->input('countryOfResidence'),
    'religion' => $request->input('religion'),
    'maritalStatus' => $request->input('maritalStatus'),
    'marriedUnderSpecialAct' => $request->input('marriedUnderSpecialAct'),
    'correspondenceEmail' => $request->input('correspondenceEmail'),
    'permanentHouseFlatNo' => $request->input('permanentHouseFlatNo'),
    'permanentAddressLine1' => $request->input('permanentAddressLine1'),
    'permanentAddressLine2' => $request->input('permanentAddressLine2'),
    'permanentPincode' => $request->input('permanentPincode'),
    'permanentCity' => $request->input('permanentCity'),
    'permanentState' => $request->input('permanentState'),
    'permanentCountry' => $request->input('permanentCountry'),
    'currentHouseFlatNo' => $request->input('currentHouseFlatNo'),
    'currentAddressLine1' => $request->input('currentAddressLine1'),
    'currentAddressLine2' => $request->input('currentAddressLine2'),
    'currentPincode' => $request->input('currentPincode'),
    'currentCity' => $request->input('currentCity'),
    'currentState' => $request->input('currentState'),
    'currentCountry' => $request->input('currentCountry'),
    'adharNumber' => $request->input('adharNumber'),
    'adharName' => $request->input('adharName'),
    'panNumber' => $request->input('panNumber'),
    'panName' => $request->input('panName'),
    'passportNumber' => $request->input('passportNumber'),
    'passportName' => $request->input('passportName'),
    'passportExpiryDate' => $request->input('passportExpiryDate'),
    'placeOfIssue' => $request->input('placeOfIssue'),
    'drivingLicenceNumber' => $request->input('drivingLicenceNumber'),
    'drivingLicenceName' => $request->input('drivingLicenceName'),
    'drivingLicenceExpiryDate' => $request->input('drivingLicenceExpiryDate'),
    'drivingLicencePlaceOfIssue' => $request->input('drivingLicencePlaceOfIssue'),
    'adharFile' => $aadharFileNameToStore,
    'panFile' => $panFileNameToStore,
    'passportFile' => $paasportFileNameToStore,
    'drivingLicenceFile' => $dlFileNameToStore,
]);

  return response()->json(['success'=>true, 'message'=> 'Profie details added successfully', 'profile'=>$profile],201);


    }




}
