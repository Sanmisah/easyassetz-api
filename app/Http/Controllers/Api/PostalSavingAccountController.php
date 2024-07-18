<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\PostalSavingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\PostalSavingAccountResource;
use App\Http\Requests\StorePostalSavingAccountRequest;
use App\Http\Requests\UpdatePostalSavingAccountRequest;

class PostalSavingAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $postalSavingAccount = $user->profile->postalSavingAccount()->with('nominee')->get();
        return $this->sendResponse(['PostalSavingAccount'=>PostalSavingAccountResource::collection($postalSavingAccount)],'alternate investment fund details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostalSavingAccountRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $imageFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFileNameWithExtention, PATHINFO_FILENAME);
            $imageExtention = $request->file('image')->getClientOriginalExtension();
            $imageFileNameToStore = $imageFilename.'_'.time().'.'.$imageExtention;
            $imagePath = $request->file('image')->storeAs('public/PostalSavingAccount', $imageFileNameToStore);
         }

        $user = Auth::user();
        $postalSavingAccount = new PostalSavingAccount();
        $postalSavingAccount->profile_id = $user->profile->id;
        $postalSavingAccount->account_number = $request->input('accountNumber');
        $postalSavingAccount->post_office_branch = $request->input('postOfficeBranch');
        $postalSavingAccount->city = $request->input('city');
        $postalSavingAccount->holding_type = $request->input('holdingType');
        $postalSavingAccount->joint_holder_name = $request->input('jointHolderName');
        $postalSavingAccount->joint_holder_pan = $request->input('jointHolderPan');
        $postalSavingAccount->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $postalSavingAccount->image = $imageFileNameToStore;
         } 
        $postalSavingAccount->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $postalSavingAccount->nominee()->attach($nominee_id);
        }
        return $this->sendResponse(['PostalSavingAccount'=> new PostalSavingAccountResource($postalSavingAccount)], 'Postal Saving Account details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $postalSavingAccount = PostalSavingAccount::find($id);
        if(!$postalSavingAccount){
            return $this->sendError('Postal Saving Account Not Found',['error'=>'Postal Saving Account details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $postalSavingAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Postal saving Account details']);
         }
         $postalSavingAccount->load('nominee');
        return $this->sendResponse(['PostalSavingAccount'=>new PostalSavingAccountResource($postalSavingAccount)], 'Postal Saving Account details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostalSavingAccountRequest $request, string $id): JsonResponse
    {

        if($request->hasFile('image')){
            $imageFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFileNameWithExtention, PATHINFO_FILENAME);
            $imageExtention = $request->file('image')->getClientOriginalExtension();
            $imageFileNameToStore = $imageFilename.'_'.time().'.'.$imageExtention;
            $imagePath = $request->file('image')->storeAs('public/PostalSavingAccount', $imageFileNameToStore);
         }

        $postalSavingAccount = PostalSavingAccount::find($id);
        if(!$postalSavingAccount){
            return $this->sendError('Postal Saving Account Not Found',['error'=>'Postal Saving Account details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $postalSavingAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Postal Saving Account details']);
         }

         $postalSavingAccount->account_number = $request->input('accountNumber');
         $postalSavingAccount->post_office_branch = $request->input('postOfficeBranch');
         $postalSavingAccount->city = $request->input('city');
         $postalSavingAccount->holding_type = $request->input('holdingType');
         $postalSavingAccount->joint_holder_name = $request->input('jointHolderName');
         $postalSavingAccount->joint_holder_pan = $request->input('jointHolderPan');
         $postalSavingAccount->additional_details = $request->input('additionalDetails');
         if($request->hasFile('image')){
             $postalSavingAccount->image = $imageFileNameToStore;
          } 
         $postalSavingAccount->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $postalSavingAccount->nominee()->sync($nominee_ids);
        }else {
            $postalSavingAccount->nominee()->detach();
        }
       
        return $this->sendResponse(['PostalSavingAccount'=>new PostalSavingAccountResource($postalSavingAccount)], 'Postal Saving Account details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $postalSavingAccount = PostalSavingAccount::find($id);
        if(!$postalSavingAccount){
            return $this->sendError('Postal Saving Account not found', ['error'=>'Postal Saving Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $postalSavingAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Postal Saving Account']);
        }

        if(!empty($postalSavingAccount->image) && Storage::exists('public/PostalSavingAccount/'.$postalSavingAccount->image)) {
            Storage::delete('public/PostalSavingAccount/'.$postalSavingAccount->image);
        }
        
        $postalSavingAccount->delete();

        return $this->sendResponse([], 'Postal Saving Account deleted successfully');
    }

}
