<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\InvestmentFund;
use Illuminate\Http\JsonResponse;
use App\Models\OtherFinancialAsset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\OtherFinancialAssetResource;
use App\Http\Requests\StoreOtherFinancialAssetRequest;
use App\Http\Requests\UpdateOtherFinancialAssetRequest;

class OtherFinancialAssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $otherFinancialAsset = $user->profile->otherFinancialAsset()->with('nominee')->get();
        return $this->sendResponse(['OtherFinancialAsset'=>OtherFinancialAssetResource::collection($otherFinancialAsset)],'Other financial assets details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOtherFinancialAssetRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $ofaFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $ofaFilename = pathinfo($ofaFileNameWithExtention, PATHINFO_FILENAME);
            $ofaExtention = $request->file('image')->getClientOriginalExtension();
            $ofaFileNameToStore = $ofaFilename.'_'.time().'.'.$ofaExtention;
            $ofaPath = $request->file('image')->storeAs('public/OtherFinancialAsset', $ofaFileNameToStore);
         }

        $user = Auth::user();
        $otherFinancialAsset = new OtherFinancialAsset();
        $otherFinancialAsset->profile_id = $user->profile->id;
        $otherFinancialAsset->bank_service_provider = $request->input('bankServiceProvider');
        $otherFinancialAsset->folio_number = $request->input('folioNumber');
        $otherFinancialAsset->branch_name = $request->input('branchName');
        $otherFinancialAsset->nature_of_holding = $request->input('natureOfHolding');
        $otherFinancialAsset->joint_holder_name = $request->input('jointHolderName');
        $otherFinancialAsset->joint_holder_pan = $request->input('jointHolderPan');
        $otherFinancialAsset->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $otherFinancialAsset->image = $ofaFileNameToStore;
         } 
        $otherFinancialAsset->name = $request->input('name');
        $otherFinancialAsset->mobile = $request->input('mobile');
        $otherFinancialAsset->email = $request->input('email');
        $otherFinancialAsset->save(); 

        // if($request->has('nominees')){
        //     $nominee_id = $request->input('nominees');
        //     $otherFinancialAsset->nominee()->attach($nominee_id);
        // }

        if ($request->has('nominees')) {
            $nominee_id = $request->input('nominees');
            // Check if nominee_id is a string and contains comma-separated values
            if (is_string($nominee_id)) {
                $nominee_id = explode(',', $nominee_id);
            }
    
            // Ensure nominee_id is an array and filter out non-integer values
            if (is_array($nominee_id)) {
                $nominee_id = array_map('intval', $nominee_id);
                $otherFinancialAsset->nominee()->attach($nominee_id);
            }
        }

        return $this->sendResponse(['OtherFinancialAsset'=> new OtherFinancialAssetResource($otherFinancialAsset)], 'Other Financial Assets details stored successfully');
   }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $otherFinancialAsset = OtherFinancialAsset::find($id);
        if(!$otherFinancialAsset){
            return $this->sendError('Other financial Asset Not Found',['error'=>'Other Financial Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherFinancialAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Financial Asset']);
         }
         $otherFinancialAsset->load('nominee');
        return $this->sendResponse(['OtherFinancialAsset'=>new OtherFinancialAssetResource($otherFinancialAsset)], 'Other Financial Assets retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtherFinancialAssetRequest $request, string $id): JsonResponse
    {
        $otherFinancialAsset = OtherFinancialAsset::find($id);
        if(!$otherFinancialAsset){
            return $this->sendError('Other Financial asset Not Found',['error'=>'Other Financial assets not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherFinancialAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Financial Assets']);
         }
         
        if($request->hasFile('image')){
            if (!empty($otherFinancialAsset->image) && Storage::exists('public/OtherFinancialAsset/'.$otherFinancialAsset->image)) {
                Storage::delete('public/OtherFinancialAsset/'.$otherFinancialAsset->image);
               }
            $ofaFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $ofaFilename = pathinfo($ofaFileNameWithExtention, PATHINFO_FILENAME);
            $ofaExtention = $request->file('image')->getClientOriginalExtension();
            $ofaFileNameToStore = $ofaFilename.'_'.time().'.'.$ofaExtention;
            $ofaPath = $request->file('image')->storeAs('public/OtherFinancialAsset', $ofaFileNameToStore);
         }

         $otherFinancialAsset->profile_id = $user->profile->id;
         $otherFinancialAsset->bank_service_provider = $request->input('bankServiceProvider');
         $otherFinancialAsset->folio_number = $request->input('folioNumber');
         $otherFinancialAsset->branch_name = $request->input('branchName');
         $otherFinancialAsset->nature_of_holding = $request->input('natureOfHolding');
         $otherFinancialAsset->joint_holder_name = $request->input('jointHolderName');
         $otherFinancialAsset->joint_holder_pan = $request->input('jointHolderPan');
         $otherFinancialAsset->additional_details = $request->input('additionalDetails');
         if($request->hasFile('image')){
             $otherFinancialAsset->image = $ofaFileNameToStore;
          } 
         $otherFinancialAsset->name = $request->input('name');
         $otherFinancialAsset->mobile = $request->input('mobile');
         $otherFinancialAsset->email = $request->input('email');
         $otherFinancialAsset->save(); 
 
        //  if($request->has('nominees')) {
        //     $nominee_ids = $request->input('nominees');
        //     $otherFinancialAsset->nominee()->sync($nominee_ids);
        // }else {
        //     $otherFinancialAsset->nominee()->detach();
        // }

        if ($request->has('nominees')) {
            // $nominee_ids = $request->input('nominees');
            $nominee_id = is_string($request->input('nominees')) 
            ? explode(',', $request->input('nominees')) 
            : $request->input('nominees');

        // Ensure nominee IDs are integers
        $nominee_id = array_map('intval', $nominee_id);
            $otherFinancialAsset->nominee()->sync($nominee_id);
        } else {
            // If no nominees selected, detach all existing nominees
            $otherFinancialAsset->nominee()->detach();
        }

         return $this->sendResponse(['OtherFinancialAsset'=> new OtherFinancialAssetResource($otherFinancialAsset)], 'Other Financial Assets details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $otherFinancialAsset = OtherFinancialAsset::find($id);
        if(!$otherFinancialAsset){
            return $this->sendError('Other Financial Assets not found', ['error'=>'Other Financial Assets not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherFinancialAsset->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Other Financial Assets']);
        }

        if (!empty($otherFinancialAsset->image) && Storage::exists('public/OtherFinancialAsset/'.$otherFinancialAsset->image)) {
            Storage::delete('public/OtherFinancialAsset/'.$otherFinancialAsset->image);
           }

        $otherFinancialAsset->delete();

        return $this->sendResponse([], 'Other Financial Assets deleted successfully');
    }
}