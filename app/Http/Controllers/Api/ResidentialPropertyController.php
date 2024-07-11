<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ResidentialProperty;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ResidentialPropertyResource;

class ResidentialPropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $residentialProperty = $user->profile->residentialProperty()->with('nominee')->get();
        return $this->sendResponse(['ResidentialProperty'=>ResidentialPropertyResource::collection($residentialProperty)],'Residential Property details retrived Successfully');
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
            $litigationPath = $request->file('litigationFile')->storeAs('public/ResidentialProperty/LitigationFiles', $portfolioFileNameToStore);
         }

        $user = Auth::user();
        $residentialProperty = new ResidentialProperty();
        $residentialProperty->profile_id = $user->profile->id;
        $residentialProperty->property_type = $request->input('propertyType');
        $residentialProperty->house_number = $request->input('houseNumber');
        $residentialProperty->address_1 = $request->input('address1');
        $residentialProperty->pincode = $request->input('pincode');
        $residentialProperty->area = $request->input('area');
        $residentialProperty->city = $request->input('city');
        $residentialProperty->state = $request->input('state');
        $residentialProperty->property_status = $request->input('propertyStatus');
        $residentialProperty->ownership_by_virtue_of = $request->input('ownershipByVirtueOf');
        $residentialProperty->ownership_type = $request->input('ownershipType');
        $residentialProperty->first_holders_name = $request->input('firstHoldersName');
        $residentialProperty->first_holders_relation = $request->input('firstHoldersRelation');
        $residentialProperty->first_holders_aadhar = $request->input('firstHoldersAadhar');
        $residentialProperty->first_holders_pan = $request->input('firstHoldersPan');
        $residentialProperty->joint_holders_name = $request->input('jointHoldersName');
        $residentialProperty->joint_holders_relation = $request->input('jointHoldersRelation');
        $residentialProperty->joint_holders_pan = $request->input('jointHoldersPan');
        $residentialProperty->any_loan_litigation = $request->input('anyLoanLitigation');
        $residentialProperty->litigationFile = $request->input('litigationFile');
        $residentialProperty->name = $request->input('name');
        $residentialProperty->mobile = $request->input('mobile');
        $residentialProperty->email = $request->input('email');
        $residentialProperty->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //
    }
}
