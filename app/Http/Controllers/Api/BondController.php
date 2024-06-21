<?php

namespace App\Http\Controllers\Api;

use App\Models\Bond;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BondResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class BondController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $bond = $user->profile->bond()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['Bond'=>BondResource::collection($bond)],'Bond retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $bond = new Bond();
        $bond->profile_id = $user->profile->id;
        $bond->bank_service_provider = $request->input('bankServiceProvider');
        $bond->company_name = $request->input('companyName');
        $bond->folio_number = $request->input('folioNumber');
        $bond->number_of_debentures = $request->input('numberOfDebentures');
        $bond->certificate_number = $request->input('certificateNumber');
        $bond->distinguish_no_from = $request->input('distinguishNoFrom');
        $bond->distinguish_no_to = $request->input('distinguishNoTo');
        $bond->face_value = $request->input('faceValue');
        $bond->nature_of_holding = $request->input('natureOfHolding');
        $bond->additional_details = $request->input('additionalDetails');
        $bond->image = $request->input('image');
        $bond->name = $request->input('name');
        $bond->mobile = $request->input('mobile');
        $bond->email = $request->input('email');
        $bond->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $bond->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $bond->jointHolder()->attach($joint_holder_id);
        }

        return $this->sendResponse(['Bond'=> new BondResource($bond)], 'Bond details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResopnse
    {
        $bond = Bond::find($id);
        if(!$bond){
            return $this->sendError('Bond Not Found',['error'=>'Bond not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bond->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bond Detail']);
         }
         $bond->load('nominee','jointHolder');
        return $this->sendResponse(['Bond'=>new BondResource($bond)], 'Bond Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $bond = Bond::find($id);
        if(!$bond){
            return $this->sendError('Bond Detail Not Found',['error'=>'Bond Detail not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bond->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bond Detail']);
         }

         $bond->bank_service_provider = $request->input('bankServiceProvider');
         $bond->company_name = $request->input('companyName');
         $bond->folio_number = $request->input('folioNumber');
         $bond->number_of_debentures = $request->input('numberOfDebentures');
         $bond->certificate_number = $request->input('certificateNumber');
         $bond->distinguish_no_from = $request->input('distinguishNoFrom');
         $bond->distinguish_no_to = $request->input('distinguishNoTo');
         $bond->face_value = $request->input('faceValue');
         $bond->nature_of_holding = $request->input('natureOfHolding');
         $bond->additional_details = $request->input('additionalDetails');
         $bond->image = $request->input('image');
         $bond->name = $request->input('name');
         $bond->mobile = $request->input('mobile');
         $bond->email = $request->input('email');
         $bond->save();
 
         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $bond->nominee()->sync($nominee_ids);
        }else {
            $bond->nominee()->detach();
        }

        if($request->has('jointHolders')) {
            $joint_holder_id = $request->input('jointHolders');
            $bond->jointHolder()->sync($joint_holder_id);
        }else {
            $bond->jointHolder()->detach();
        }

         return $this->sendResponse(['Bond'=> new BondResource($bond)], 'Bond details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $bond = Bond::find($id);
        if(!$bond){
            return $this->sendError('Bond not found', ['error'=>'Bond Details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bond->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Bond Details']);
        }
        $bond->delete();

        return $this->sendResponse([], 'Bond Details deleted successfully');

    }
}
