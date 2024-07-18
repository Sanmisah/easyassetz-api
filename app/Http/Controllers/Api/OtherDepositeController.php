<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OtherDeposite;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\OtherDepositeResource;
use App\Http\Requests\StoreOtherDepositRequest;
use App\Http\Requests\UpdateOtherDepositRequest;

class OtherDepositeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $otherDeposite = $user->profile->otherDeposite()->with('nominee')->get();
        return $this->sendResponse(['OtherDeposite'=>OtherDepositeResource::collection($otherDeposite)],'Other Deposite details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOtherDepositRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $depositFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $depositFilename = pathinfo($depositFileNameWithExtention, PATHINFO_FILENAME);
            $depositExtention = $request->file('image')->getClientOriginalExtension();
            $depositFileNameToStore = $depositFilename.'_'.time().'.'.$depositExtention;
            $depositPath = $request->file('image')->storeAs('public/OtherDeposit', $depositFileNameToStore);
         }

        $user = Auth::user();
        $otherDeposite = new OtherDeposite();
        $otherDeposite->profile_id = $user->profile->id;
        $otherDeposite->fd_number = $request->input('fdNumber');
        $otherDeposite->company = $request->input('company');
        $otherDeposite->branch_name = $request->input('branch_name');
        $otherDeposite->maturity_date = $request->input('maturity_date');
        $otherDeposite->maturity_amount = $request->input('maturity_amount');
        $otherDeposite->holding_type = $request->input('holding_type');
        $otherDeposite->joint_holder_name = $request->input('jointHolderName');
        $otherDeposite->joint_holder_pan = $request->input('jointHolderPan');
        $otherDeposite->additional_details = $request->input('additional_details');
        if($request->hasFile('image')){
            $otherDeposite->image = $depositFileNameToStore;
         } 
        $otherDeposite->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $otherDeposite->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['OtherDeposite'=> new OtherDepositeResource($otherDeposite)], 'Other Deposite details stored successfully');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $otherDeposite = OtherDeposite::find($id);
        if(!$otherDeposite){
            return $this->sendError('Other Deposite Not Found',['error'=>'Other Deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherDeposite->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Deposite']);
         }
         $otherDeposite->load('nominee');
        return $this->sendResponse(['OtherDeposite'=>new OtherDepositeResource($otherDeposite)], 'Other Deposite retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtherDepositRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $depositFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $depositFilename = pathinfo($depositFileNameWithExtention, PATHINFO_FILENAME);
            $depositExtention = $request->file('image')->getClientOriginalExtension();
            $depositFileNameToStore = $depositFilename.'_'.time().'.'.$depositExtention;
            $depositPath = $request->file('image')->storeAs('public/OtherDeposit', $depositFileNameToStore);
         }

        $otherDeposite = OtherDeposite::find($id);
        if(!$otherDeposite){
            return $this->sendError('Other Deposite Not Found',['error'=>'Other deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherDeposite->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Deposite']);
         }

         $otherDeposite->fd_number = $request->input('fdNumber');
         $otherDeposite->company = $request->input('company');
         $otherDeposite->branch_name = $request->input('branch_name');
         $otherDeposite->maturity_date = $request->input('maturity_date');
         $otherDeposite->maturity_amount = $request->input('maturity_amount');
         $otherDeposite->holding_type = $request->input('holding_type');
         $otherDeposite->joint_holder_name = $request->input('jointHolderName');
         $otherDeposite->joint_holder_pan = $request->input('jointHolderPan');
         $otherDeposite->additional_details = $request->input('additional_details');
         if($request->hasFile('image')){
            $otherDeposite->image = $depositFileNameToStore;
         } 
         $otherDeposite->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $otherDeposite->nominee()->sync($nominee_ids);
        }else {
            $otherDeposite->nominee()->detach();
        }

         return $this->sendResponse(['OtherDeposite'=> new OtherDepositeResource($otherDeposite)], 'Other Deposite details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $otherDeposite = OtherDeposite::find($id);
        if(!$otherDeposite){
            return $this->sendError('Other Deposite not found', ['error'=>'Other Deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherDeposite->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Other Deposite']);
        }

        if(!empty($otherDeposite->image) && Storage::exists('public/OtherDeposit/'.$otherDeposite->image)) {
            Storage::delete('public/OtherDeposit/'.$otherDeposite->image);
        }

        $otherDeposite->delete();

        return $this->sendResponse([], 'Other Deposite deleted successfully');
    }
}
