<?php

namespace App\Http\Controllers;

use Valdator;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function CreateBeneficiary(Request $request){
        $validator = Validator::make($request->all(),[
            'profile_id' => 'required|exists:profiles,id',
            'fullLegalName' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|string',
            'guardianFullLegalName' => 'nullable|string|max:255',
            'guardianMobileNumber' => 'required|string|max:20',
            'guardianEmail' => 'nullable|email|max:255',
            'guardianCity' => 'required|string|max:255',
            'guardianState' => 'required|string|max:255',
            'adharNumber' => 'nullable|string|max:12',
            'panNumber' => 'nullable|string|max:10',
            'passportNumber' => 'nullable|string|max:15',
            'drivingLicenceNumber' => 'nullable|string|max:20',
            'religion' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'houseFlatNo' => 'required|string|max:255',
            'addressLine1' => 'required|string|max:255',
            'addressLine2' => 'nullable|string|max:255',
            'pincode' => 'required|string|max:10',
            'beneficiaryCity' => 'required|string|max:255',
            'beneficiaryState' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
    
        ]);

        if($validator->fails()){
            return response()->json(['success'=>false, 'message'=>$validator->errors()], 401);
        }

        $beneficiary = Beneficiary::create([
            'profile_id' => $request->input('profile_id'),
            'fullLegalName' => $request->input('fullLegalName'),
            'relationship' => $request->input('relationship'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'guardianFullLegalName' => $request->input('guardianFullLegalName'),
            'guardianMobileNumber' => $request->input('guardianMobileNumber'),
            'guardianEmail' => $request->input('guardianEmail'),
            'guardianCity' => $request->input('guardianCity'),
            'guardianState' => $request->input('guardianState'),
            'adharNumber' => $request->input('adharNumber'),
            'panNumber' => $request->input('panNumber'),
            'passportNumber' => $request->input('passportNumber'),
            'drivingLicenceNumber' => $request->input('drivingLicenceNumber'),
            'religion' => $request->input('religion'),
            'nationality' => $request->input('nationality'),
            'houseFlatNo' => $request->input('houseFlatNo'),
            'addressLine1' => $request->input('addressLine1'),
            'addressLine2' => $request->input('addressLine2'),
            'pincode' => $request->input('pincode'),
            'beneficiaryCity' => $request->input('beneficiaryCity'),
            'beneficiaryState' => $request->input('beneficiaryState'),
            'country' => $request->input('country'),
        ]);
        
        return response()->json(['success' => true, 'message' => 'Beneficiary created successfully', 'beneficiary' => $beneficiary], 201);
        

            
    }

}
