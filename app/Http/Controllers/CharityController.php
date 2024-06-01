<?php

namespace App\Http\Controllers;

use validator;
use App\Models\Charity;
use Illuminate\Http\Request;

class CharityController extends Controller
{
    public function CreateCharity(Request $request){
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required|exists:profiles,id',
            'organizationName' => 'required|string|max:255',
            'address1' => 'nullable|string|max:65535',
            'address2' => 'nullable|string|max:65535',
            'charityCity' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'contactPerson' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'specificInstruction' => 'nullable|string|max:300'
        ]);

        if($validator->fails()){
            return response()->json(['success'=>false, 'message'=>$validator->errors()], 401);
        }

        $charity = Charity::create([
            'profile_id' => $request->input('profile_id'),
            'organizationName' => $request->input('organizationName'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'charityCity' => $request->input('charityCity'),
            'state' => $request->input('state'),
            'phoneNumber' => $request->input('phoneNumber'),
            'email' => $request->input('email'),
            'contactPerson' => $request->input('contactPerson'),
            'website' => $request->input('website'),
            'specificInstruction' => $request->input('specificInstruction'),
        ]);
        
        return response()->json(['success' => true, 'message' => 'Charity created successfully', 'charity' => $charity], 201);
        
        
    }
}
