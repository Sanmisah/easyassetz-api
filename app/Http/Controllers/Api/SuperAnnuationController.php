<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SuperAnnuation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\SuperAnnuationResource;

class SuperAnnuationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $superAnnuation = $user->profile->superAnnuation()->with('nominee')->get();
        return $this->sendResponse(['SuperAnnuation'=>SuperAnnuationResource::collection($superAnnuation)],'Super Annuation details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $saFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $saFilename = pathinfo($saFileNameWithExtention, PATHINFO_FILENAME);
            $saExtention = $request->file('image')->getClientOriginalExtension();
            $saFileNameToStore = $saFilename.'_'.time().'.'.$saExtention;
            $saPath = $request->file('image')->storeAs('public/SuperAnnuation', $saFileNameToStore);
         }

        $user = Auth::user();
        $superAnnuation = new SuperAnnuation();
        $superAnnuation->profile_id = $user->profile->id;
        $superAnnuation->company_name = $request->input('companyName');
        $superAnnuation->master_policy_number = $request->input('masterPolicyNumber');
        $superAnnuation->emp_no = $request->input('empNo');
        $superAnnuation->address = $request->input('address');
        $superAnnuation->annuity_amount = $request->input('annuityAmount');
        $superAnnuation->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $superAnnuation->image = $saFileNameToStore;
         } 
        $superAnnuation->name = $request->input('name');
        $superAnnuation->mobile = $request->input('mobile');
        $superAnnuation->email = $request->input('email');
        $superAnnuation->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $superAnnuation->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['SuperAnnuation'=> new SuperAnnuationResource($superAnnuation)], 'Super Annuation details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $superAnnuation = SuperAnnuation::find($id);
        if(!$superAnnuation){
            return $this->sendError('Super Annuation Not Found',['error'=>'Super Annuation not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $superAnnuation->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Super Annuation']);
         }
         $superAnnuation->load('nominee');
        return $this->sendResponse(['SuperAnnuation'=>new SuperAnnuationResource($superAnnuation)], 'Super Annuation retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $saFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $saFilename = pathinfo($saFileNameWithExtention, PATHINFO_FILENAME);
            $saExtention = $request->file('image')->getClientOriginalExtension();
            $saFileNameToStore = $saFilename.'_'.time().'.'.$saExtention;
            $saPath = $request->file('image')->storeAs('public/SuperAnnuation', $saFileNameToStore);
         }

         $superAnnuation = SuperAnnuation::find($id);
         if(!$superAnnuation){
             return $this->sendError('Super Annuation Not Found',['error'=>'Super Annuation details not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $superAnnuation->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Super Annuation']);
          }

          $superAnnuation->company_name = $request->input('companyName');
          $superAnnuation->master_policy_number = $request->input('masterPolicyNumber');
          $superAnnuation->emp_no = $request->input('empNo');
          $superAnnuation->address = $request->input('address');
          $superAnnuation->annuity_amount = $request->input('annuityAmount');
          $superAnnuation->additional_details = $request->input('additionalDetails');
          if($request->hasFile('image')){
              $superAnnuation->image = $saFileNameToStore;
           } 
          $superAnnuation->name = $request->input('name');
          $superAnnuation->mobile = $request->input('mobile');
          $superAnnuation->email = $request->input('email');
          $superAnnuation->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $superAnnuation->nominee()->sync($nominee_ids);
        }else {
            $superAnnuation->nominee()->detach();
        }

         return $this->sendResponse(['SuperAnnuation'=> new SuperAnnuationResource($superAnnuation)], 'Super Annuation details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $superAnnuation = SuperAnnuation::find($id);
        if(!$superAnnuation){
            return $this->sendError('Super Annuation not found', ['error'=>'Super Annuation not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $superAnnuation->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Super Annuation']);
        }
        $superAnnuation->delete();

        return $this->sendResponse([], 'Super Annuation deleted successfully');
    }
}
