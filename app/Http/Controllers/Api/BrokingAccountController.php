<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BrokingAccount;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BrokingAccountResource;
use App\Http\Requests\StoreBrokingAccountRequest;
use App\Http\Requests\UpdateBrokingAccountRequest;

class BrokingAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $brokingAccount = $user->profile->brokingAccount()->with('nominee')->get();
        return $this->sendResponse(['BrokingAccount'=>BrokingAccountResource::collection($brokingAccount)],'Broking account retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrokingAccountRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $brokingFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $brokingFilename = pathinfo($brokingFileNameWithExtention, PATHINFO_FILENAME);
            $brokingExtention = $request->file('image')->getClientOriginalExtension();
            $brokingFileNameToStore = $brokingFilename.'_'.time().'.'.$brokingExtention;
            $brokingPath = $request->file('image')->storeAs('public/BrokingAccount', $brokingFileNameToStore);
         }

        $user = Auth::user();
        $brokingAccount = new BrokingAccount();
        $brokingAccount->profile_id = $user->profile->id;
        $brokingAccount->broker_name = $request->input('brokerName');
        $brokingAccount->broking_account_number = $request->input('brokingAccountNumber');
        $brokingAccount->nature_of_holding = $request->input('natureOfHolding');
        $brokingAccount->joint_holder_name = $request->input('jointHolderName');
        $brokingAccount->joint_holder_pan = $request->input('jointHolderPan');
        $brokingAccount->additional_details = $request->input('additionalDetails');
        $brokingAccount->name = $request->input('name');
        $brokingAccount->mobile = $request->input('mobile');
        $brokingAccount->email = $request->input('email');
        if($request->hasFile('image')){
            $brokingAccount->image = $brokingFileNameToStore;
         } 
        $brokingAccount->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $brokingAccount->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['BrokingAccount'=> new BrokingAccountResource($brokingAccount)], 'Broking Account details stored successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $brokingAccount = BrokingAccount::find($id);
        if(!$brokingAccount){
            return $this->sendError('Broking Account Not Found',['error'=>'Broking Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $brokingAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Broking Account']);
         }
         $brokingAccount->load('nominee');
        return $this->sendResponse(['BrokingAccount'=>new BrokingAccountResource($brokingAccount)], 'Broking Account retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrokingAccountRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $brokingFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $brokingFilename = pathinfo($brokingFileNameWithExtention, PATHINFO_FILENAME);
            $brokingExtention = $request->file('image')->getClientOriginalExtension();
            $brokingFileNameToStore = $brokingFilename.'_'.time().'.'.$brokingExtention;
            $brokingPath = $request->file('image')->storeAs('public/BrokingAccount', $brokingFileNameToStore);
         }

         $brokingAccount = BrokingAccount::find($id);
         if(!$brokingAccount){
             return $this->sendError('Broking Account Not Found',['error'=>'Broking Account not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $brokingAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Broking Account']);
          }

          $brokingAccount->broker_name = $request->input('brokerName');
          $brokingAccount->broking_account_number = $request->input('brokingAccountNumber');
          $brokingAccount->nature_of_holding = $request->input('natureOfHolding');
          $brokingAccount->joint_holder_name = $request->input('jointHolderName');
          $brokingAccount->joint_holder_pan = $request->input('jointHolderPan');
          $brokingAccount->additional_details = $request->input('additionalDetails');
          $brokingAccount->name = $request->input('name');
          $brokingAccount->mobile = $request->input('mobile');
          $brokingAccount->email = $request->input('email');
          if($request->hasFile('image')){
              $brokingAccount->image = $brokingFileNameToStore;
           } 
          $brokingAccount->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $brokingAccount->nominee()->sync($nominee_ids);
        }else {
            $brokingAccount->nominee()->detach();
        }

         return $this->sendResponse(['BrokingAccount'=> new BrokingAccountResource($brokingAccount)], 'Broking Account details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $brokingAccount = BrokingAccount::find($id);
        if(!$brokingAccount){
            return $this->sendError('Broking Account not found', ['error'=>'Broking Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $brokingAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Broking Account']);
        }

        if (!empty($brokingAccount->image) && Storage::exists('public/BrokingAccount/'.$brokingAccount->image)) {
            Storage::delete('public/BrokingAccount/'.$brokingAccount->image);
           }

        $brokingAccount->delete();

        return $this->sendResponse([], 'Broking Account deleted successfully');
    }
}
