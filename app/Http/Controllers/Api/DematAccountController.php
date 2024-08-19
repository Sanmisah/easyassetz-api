<?php

namespace App\Http\Controllers\Api;

use App\Models\DematAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\DematAccountResource;
use App\Http\Requests\StoreDematAccountRequest;
use App\Http\Requests\UpdateDematAccountRequest;

class DematAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $dematAccount = $user->profile->dematAccount()->with('nominee')->get();
        return $this->sendResponse(['DematAccount'=>DematAccountResource::collection($dematAccount)],'Demat account retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDematAccountRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $dematFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $dematFilename = pathinfo($dematFileNameWithExtention, PATHINFO_FILENAME);
            $dematExtention = $request->file('image')->getClientOriginalExtension();
            $dematFileNameToStore = $dematFilename.'_'.time().'.'.$dematExtention;
            $dematPath = $request->file('image')->storeAs('public/DematAccount', $dematFileNameToStore);
         }

        $user = Auth::user();
        $dematAccount = new DematAccount();
        $dematAccount->profile_id = $user->profile->id;
        $dematAccount->depository = $request->input('depository');
        $dematAccount->depository_name = $request->input('depositoryName');
        $dematAccount->depository_id = $request->input('depositoryId');
        $dematAccount->account_number = $request->input('accountNumber');
        $dematAccount->nature_of_holding = $request->input('natureOfHolding');
        $dematAccount->joint_holder_name = $request->input('jointHolderName');
        $dematAccount->joint_holder_pan = $request->input('jointHolderPan');
        $dematAccount->additional_details = $request->input('additionalDetails');
        $dematAccount->name = $request->input('name');
        $dematAccount->mobile = $request->input('mobile');
        $dematAccount->email = $request->input('email');
        if($request->hasFile('image')){
            $dematAccount->image = $dematFileNameToStore;
         }
        $dematAccount->save();

        // if($request->has('nominees')){
        //     $nominee_id = $request->input('nominees');
        //     $dematAccount->nominee()->attach($nominee_id);
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
                $dematAccount->nominee()->attach($nominee_id);
            }
        }

        return $this->sendResponse(['DematAccount'=> new DematAccountResource($dematAccount)], 'Demat Account details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $dematAccount = DematAccount::find($id);
        if(!$dematAccount){
            return $this->sendError('DematAccount Not Found',['error'=>'Demat Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $dematAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Demat Account']);
         }
         $dematAccount->load('nominee');
        return $this->sendResponse(['DematAccount'=>new DematAccountResource($dematAccount)], 'Demat Account retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDematAccountRequest $request, string $id): JsonResponse
    {
        $dematAccount = DematAccount::find($id);
        if(!$dematAccount){
            return $this->sendError('Demat Account Not Found',['error'=>'Demat Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $dematAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Demat Account']);
         }
         
        if($request->hasFile('image')){
            if(!empty($dematAccount->image) && Storage::exists('public/DematAccount/'.$dematAccount->image)) {
                Storage::delete('public/DematAccount/'.$dematAccount->image);
               }
            $dematFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $dematFilename = pathinfo($dematFileNameWithExtention, PATHINFO_FILENAME);
            $dematExtention = $request->file('image')->getClientOriginalExtension();
            $dematFileNameToStore = $dematFilename.'_'.time().'.'.$dematExtention;
            $dematPath = $request->file('image')->storeAs('public/DematAccount', $dematFileNameToStore);
         }

        $dematAccount->depository_name = $request->input('depositoryName');
        $dematAccount->depository_id = $request->input('depositoryId');
        $dematAccount->account_number = $request->input('accountNumber');
        $dematAccount->nature_of_holding = $request->input('natureOfHolding');
        $dematAccount->joint_holder_name = $request->input('jointHolderName');
        $dematAccount->joint_holder_pan = $request->input('jointHolderPan');
        $dematAccount->additional_details = $request->input('additionalDetails');
        $dematAccount->name = $request->input('name');
        $dematAccount->mobile = $request->input('mobile');
        $dematAccount->email = $request->input('email');
        if($request->hasFile('image')){
            $dematAccount->image = $dematFileNameToStore;
         }
        $dematAccount->save();

        // if($request->has('nominees')) {
        //     $nominee_ids = $request->input('nominees');
        //     $dematAccount->nominee()->sync($nominee_ids);
        // }else {
        //     $dematAccount->nominee()->detach();
        // }

        if ($request->has('nominees')) {
            // $nominee_ids = $request->input('nominees');
            $nominee_id = is_string($request->input('nominees')) 
            ? explode(',', $request->input('nominees')) 
            : $request->input('nominees');

        // Ensure nominee IDs are integers
        $nominee_id = array_map('intval', $nominee_id);
            $dematAccount->nominee()->sync($nominee_id);
        } else {
            // If no nominees selected, detach all existing nominees
            $dematAccount->nominee()->detach();
        }

         return $this->sendResponse(['DematAccount'=> new DematAccountResource($dematAccount)], 'Demat Account details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $dematAccount = DematAccount::find($id);
        if(!$dematAccount){
            return $this->sendError('Demat Account not found', ['error'=>'Demat Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $dematAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Demat Account']);
        }

        if(!empty($dematAccount->image) && Storage::exists('public/DematAccount/'.$dematAccount->image)) {
            Storage::delete('public/DematAccount/'.$dematAccount->image);
           }

        $dematAccount->delete();

        return $this->sendResponse([], 'Demat Account deleted successfully');
    }


}