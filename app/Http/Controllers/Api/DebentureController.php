<?php

namespace App\Http\Controllers\Api;

use App\Models\Debenture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DebentureResource;
use App\Http\Resources\MutualFundResource;
use App\Http\Controllers\Api\BaseController;

class DebentureController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $debenture = $user->profile->debenture()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['MutualFund'=>DebentureResource::collection($debenture)],'Debentures retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $debenture = new Debenture();
        $debenture->profile_id = $user->profile->id;
        $debenture->bank_service_provider = $request->input('bankServiceProvider');
        $debenture->company_name = $request->input('companyName');
        $debenture->folio_number = $request->input('folioNumber');
        $debenture->number_of_debentures = $request->input('numberOfDebentures');
        $debenture->certificate_number = $request->input('certificateNumber');
        $debenture->distinguish_no_from = $request->input('distinguishNoFrom');
        $debenture->distinguish_no_to = $request->input('distinguishNoTo');
        $debenture->face_value = $request->input('faceValue');
        $debenture->nature_of_holding = $request->input('natureOfHolding');
        $debenture->additional_details = $request->input('additionalDetails');
        $debenture->image = $request->input('image');
        $debenture->name = $request->input('name');
        $debenture->mobile = $request->input('mobile');
        $debenture->email = $request->input('email');
        $debenture->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $debenture->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $debenture->jointHolder()->attach($joint_holder_id);
        }

        return $this->sendResponse(['Debenture'=> new DebentureResource($debenture)], 'Debenture details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $debenture = Debenture::find($id);
        if(!$debenture){
            return $this->sendError('Debenture Not Found',['error'=>'Debenture not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $debenture->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Debenture Detail']);
         }
         $debenture->load('nominee','jointHolder');
        return $this->sendResponse(['Debenture'=>new DebentureResource($debenture)], 'Debenture Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $debenture = Debenture::find($id);
        if(!$debenture){
            return $this->sendError('Debenture Detail Not Found',['error'=>'Debenture Detail not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $debenture->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Debenture Detail']);
         }

         $debenture->bank_service_provider = $request->input('bankServiceProvider');
         $debenture->company_name = $request->input('companyName');
         $debenture->folio_number = $request->input('folioNumber');
         $debenture->number_of_debentures = $request->input('numberOfDebentures');
         $debenture->certificate_number = $request->input('certificateNumber');
         $debenture->distinguish_no_from = $request->input('distinguishNoFrom');
         $debenture->distinguish_no_to = $request->input('distinguishNoTo');
         $debenture->face_value = $request->input('faceValue');
         $debenture->nature_of_holding = $request->input('natureOfHolding');
         $debenture->additional_details = $request->input('additionalDetails');
         $debenture->image = $request->input('image');
         $debenture->name = $request->input('name');
         $debenture->mobile = $request->input('mobile');
         $debenture->email = $request->input('email');
         $debenture->save();
 
         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $debenture->nominee()->sync($nominee_ids);
        }else {
            $debenture->nominee()->detach();
        }

        if($request->has('jointHolders')) {
            $joint_holder_id = $request->input('jointHolders');
            $debenture->jointHolder()->sync($joint_holder_id);
        }else {
            $debenture->jointHolder()->detach();
        }

         return $this->sendResponse(['Debenture'=> new DebentureResource($debenture)], 'Debentuere details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $debenture = Debenture::find($id);
        if(!$debenture){
            return $this->sendError('Debenture not found', ['error'=>'Debenture Details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $debenture->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Debenture Details']);
        }
        $debenture->delete();

        return $this->sendResponse([], 'Debenture Details deleted successfully');
    }
    
}
