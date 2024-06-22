<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\WealthManagementAccount;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\WealthManagementAccountResource;

class WealthManagementAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $wealthManagementAccount = $user->profile->wealthManagementAccount()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['WealthManagementAccount'=>WealthManagementAccountResource::collection($wealthManagementAccount)],'wealth management account retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('wealthManagementFile')){
            $wealthFileNameWithExtention = $request->file('wealthManagementFile')->getClientOriginalName();
            $wealthFilename = pathinfo($wealthFileNameWithExtention, PATHINFO_FILENAME);
            $wealthExtention = $request->file('wealthManagementFile')->getClientOriginalExtension();
            $wealthFileNameToStore = $wealthFilename.'_'.time().'.'.$wealthExtention;
            $wealthPath = $request->file('wealthManagementFile')->storeAs('public/wealthManagementFile', $wealthFileNameToStore);
         }

        $user = Auth::user();
        $wealthManagementAccount = new WealthManagementAccount();
        $wealthManagementAccount->profile_id = $user->profile->id;
        $wealthManagementAccount->wealth_manager_name = $request->input('wealthManagerName');
        $wealthManagementAccount->account_number = $request->input('accountNumber');
        $wealthManagementAccount->nature_of_holding = $request->input('natureOfHolding');
        $wealthManagementAccount->additional_details = $request->input('additionalDetails');
        $wealthManagementAccount->name = $request->input('name');
        $wealthManagementAccount->mobile = $request->input('mobile');
        $wealthManagementAccount->email = $request->input('email');
        if($request->hasFile('wealthManagementFile')){
            $wealthManagementAccount->image = $wealthFileNameToStore;
         }
        $wealthManagementAccount->save();
          
        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $wealthManagementAccount->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $wealthManagementAccount->jointHolder()->attach($joint_holder_id);
        }

        return $this->sendResponse(['WealthManagementAccount'=> new WealthManagementAccountResource($wealthManagementAccount)], 'wealth management Account details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
          $wealthManagementAccount = WealthManagementAccount::find($id);
        if(!$wealthManagementAccount){
            return $this->sendError('Wealth management Not Found',['error'=>'wealth management Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $wealthManagementAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this wealth management Account']);
         }
         $wealthManagementAccount->load('nominee','jointHolder');
        return $this->sendResponse(['WealthManagementAccount'=>new WealthManagementAccountResource($wealthManagementAccount)], 'Wealth Management Account retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('wealthManagementFile')){
            $wealthFileNameWithExtention = $request->file('wealthManagementFile')->getClientOriginalName();
            $wealthFilename = pathinfo($wealthFileNameWithExtention, PATHINFO_FILENAME);
            $wealthExtention = $request->file('wealthManagementFile')->getClientOriginalExtension();
            $wealthFileNameToStore = $wealthFilename.'_'.time().'.'.$wealthExtention;
            $wealthPath = $request->file('wealthManagementFile')->storeAs('public/wealthManagementFile', $wealthFileNameToStore);
         }

         $wealthManagementAccount = WealthManagementAccount::find($id);
         if(!$wealthManagementAccount){
             return $this->sendError('Wealth management Account Not Found',['error'=>'wealth management Account not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $wealthManagementAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Wealth management Account']);
          }

          $wealthManagementAccount->profile_id = $user->profile->id;
          $wealthManagementAccount->wealth_manager_name = $request->input('wealthManagerName');
          $wealthManagementAccount->account_number = $request->input('accountNumber');
          $wealthManagementAccount->nature_of_holding = $request->input('natureOfHolding');
          $wealthManagementAccount->additional_details = $request->input('additionalDetails');
          $wealthManagementAccount->name = $request->input('name');
          $wealthManagementAccount->mobile = $request->input('mobile');
          $wealthManagementAccount->email = $request->input('email');
          if($request->hasFile('wealthManagementFile')){
            $wealthManagementAccount->image = $wealthFileNameToStore;
         }
          $wealthManagementAccount->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $wealthManagementAccount->nominee()->sync($nominee_ids);
        }else {
            $wealthManagementAccount->nominee()->detach();
        }

        if($request->has('jointHolder')) {
            $joint_holder_id = $request->input('jointHolder');
            $wealthManagementAccount->jointHolder()->sync($joint_holder_id);
        }else {
            $wealthManagementAccount->jointHolder()->detach();
        }

         return $this->sendResponse(['WealthManagementAccount'=> new WealthManagementAccountResource($wealthManagementAccount)], 'Wealth Management Account details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $wealthManagementAccount = WealthManagementAccount::find($id);
        if(!$wealthManagementAccount){
            return $this->sendError('Wealth Management Account not found', ['error'=>'Wealth Management Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $wealthManagementAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Wealth Management Account']);
        }
        $wealthManagementAccount->delete();

        return $this->sendResponse([], 'Wealth Management Account deleted successfully');
    }

}
