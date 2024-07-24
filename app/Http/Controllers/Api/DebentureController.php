<?php

namespace App\Http\Controllers\Api;

use App\Models\Debenture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\DebentureResource;
use App\Http\Resources\MutualFundResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreDebentureRequest;
use App\Http\Requests\UpdateDebentureRequest;

class DebentureController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $debenture = $user->profile->debenture()->with('nominee')->get();
        return $this->sendResponse(['Debenture'=>DebentureResource::collection($debenture)],'Debentures retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDebentureRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $debentureFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $debentureFilename = pathinfo($debentureFileNameWithExtention, PATHINFO_FILENAME);
            $debentureExtention = $request->file('image')->getClientOriginalExtension();
            $debentureFileNameToStore = $debentureFilename.'_'.time().'.'.$debentureExtention;
            $debenturePath = $request->file('image')->storeAs('public/Debenture', $debentureFileNameToStore);
         }

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
        $debenture->joint_holder_name = $request->input('jointHolderName');
        $debenture->joint_holder_pan = $request->input('jointHolderPan');
        $debenture->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $debenture->image = $debentureFileNameToStore;
         }
        $debenture->name = $request->input('name');
        $debenture->mobile = $request->input('mobile');
        $debenture->email = $request->input('email');
        $debenture->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $debenture->nominee()->attach($nominee_id);
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
         $debenture->load('nominee');
        return $this->sendResponse(['Debenture'=>new DebentureResource($debenture)], 'Debenture Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebentureRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $debentureFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $debentureFilename = pathinfo($debentureFileNameWithExtention, PATHINFO_FILENAME);
            $debentureExtention = $request->file('image')->getClientOriginalExtension();
            $debentureFileNameToStore = $debentureFilename.'_'.time().'.'.$debentureExtention;
            $debenturePath = $request->file('image')->storeAs('public/Debenture', $debentureFileNameToStore);
         }

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
         $debenture->joint_holder_name = $request->input('jointHolderName');
         $debenture->joint_holder_pan = $request->input('jointHolderPan');
         $debenture->additional_details = $request->input('additionalDetails');
         if($request->hasFile('image')){
            $debenture->image = $debentureFileNameToStore;
         }
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
        
        if (!empty($debenture->image) && Storage::exists('public/Debenture/'.$debenture->image)) {
            Storage::delete('public/Debenture/'.$debenture->image);
           }

        $debenture->delete();

        return $this->sendResponse([], 'Debenture Details deleted successfully');
    }
    
}
