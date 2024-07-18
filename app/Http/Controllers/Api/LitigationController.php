<?php

namespace App\Http\Controllers\Api;

use App\Models\Litigation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\LitigationResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreLitigationRequest;
use App\Http\Requests\UpdateLitigationRequest;

class LitigationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $litigation = $user->profile->litigation()->get();
        return $this->sendResponse(['Litigation'=>LitigationResource::collection($litigation)], "Other Loan retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLitigationRequest $request): JsonResponse
    {

        if($request->hasFile('image')){
            $litigationFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('image')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('image')->storeAs('public/Litigation', $litigationFileNameToStore);
         }

        $user = Auth::user();
        $litigation = new Litigation();
        $litigation->profile_id = $user->profile->id;
        $litigation->litigation_type = $request->input('litigationType');
        $litigation->court_name = $request->input('courtName');
        $litigation->city = $request->input('city');
        $litigation->case_registration_number = $request->input('caseRegistrationNumber');
        $litigation->my_status = $request->input('myStatus');
        $litigation->other_party_name = $request->input('otherPartyName');
        $litigation->other_party_address = $request->input('otherPartyAddress');
        $litigation->lawyer_name = $request->input('lawyerName');
        $litigation->lawyer_contact = $request->input('lawyerContact');
        $litigation->case_filling_date = $request->input('caseFillingDate');
        $litigation->status = $request->input('status');
        if($request->hasFile('image')){
            $litigation->image = $litigationFileNameToStore;
         }
        $litigation->additional_information = $request->input('additionalInformation');
        $litigation->save();

        return $this->sendResponse(['Litigation'=> new LitigationResource($litigation)], 'Litigation details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $litigation = Litigation::find($id);
        if(!$litigation){
            return $this->sendError('Litigation Not Found',['error'=>'Litigation not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $litigation->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Litigation']);
         }

        return $this->sendResponse(['Litigation'=>new LitigationResource($litigation)], 'Litigation retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLitigationRequest $request, string $id): JsonResponse
    {

        if($request->hasFile('image')){
            $litigationFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $litigationFilename = pathinfo($litigationFileNameWithExtention, PATHINFO_FILENAME);
            $litigationExtention = $request->file('image')->getClientOriginalExtension();
            $litigationFileNameToStore = $litigationFilename.'_'.time().'.'.$litigationExtention;
            $litigationPath = $request->file('image')->storeAs('public/Litigation', $litigationFileNameToStore);
         }

        $litigation = Litigation::find($id);
        if(!$litigation){
            return $this->sendError('Other Insurance Not Found',['error'=>'Other Insurance not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $litigation->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Insurance']);
         }

        $litigation->litigation_type = $request->input('litigationType');
        $litigation->court_name = $request->input('courtName');
        $litigation->city = $request->input('city');
        $litigation->case_registration_number = $request->input('caseRegistrationNumber');
        $litigation->my_status = $request->input('myStatus');
        $litigation->other_party_name = $request->input('otherPartyName');
        $litigation->other_party_address = $request->input('otherPartyAddress');
        $litigation->lawyer_name = $request->input('lawyerName');
        $litigation->lawyer_contact = $request->input('lawyerContact');
        $litigation->case_filling_date = $request->input('caseFillingDate');
        $litigation->status = $request->input('status');
        if($request->hasFile('image')){
            $litigation->image = $litigationFileNameToStore;
         }
        $litigation->additional_information = $request->input('additionalInformation');
        $litigation->save();

        return $this->sendResponse(['Litigation'=> new LitigationResource($litigation)], 'Litigation details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $litigation = Litigation::find($id);
        if(!$litigation){
            return $this->sendError('Litigation not found', ['error'=>'Litigation not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $litigation->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Litigation']);
        }

        if(!empty($litigation->image) && Storage::exists('public/Litigation/'.$litigation->image)) {
            Storage::delete('public/Litigation/'.$litigation->image);
        }

        $litigation->delete();

        return $this->sendResponse([], 'Litigation deleted successfully');
    }
}
