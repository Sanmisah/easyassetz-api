<?php

namespace App\Http\Controllers\Api;

use App\Models\FixDeposite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FixDepositeResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreFixDepositRequest;
use App\Http\Requests\UpdateFixDepositRequest;

class FixDepositeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $fixDeposite = $user->profile->fixDeposite()->with('nominee')->get();
        return $this->sendResponse(['FixDeposite'=>FixDepositeResource::collection($fixDeposite)],'Fix deposite details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFixDepositRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $fdFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $fdFilename = pathinfo($fdFileNameWithExtention, PATHINFO_FILENAME);
            $fdExtention = $request->file('image')->getClientOriginalExtension();
            $fdFileNameToStore = $fdFilename.'_'.time().'.'.$fdExtention;
            $fdPath = $request->file('image')->storeAs('public/FixDeposite', $fdFileNameToStore);
         }

        $user = Auth::user();
        $fixDeposit = new FixDeposite();
        $fixDeposit->profile_id = $user->profile->id;
        $fixDeposit->fix_deposite_number = $request->input('fixDepositeNumber');
        $fixDeposit->bank_name = $request->input('bankName');
        $fixDeposit->branch_name = $request->input('branchName');
        $fixDeposit->maturity_date = $request->input('maturityDate');
        $fixDeposit->maturity_ammount = $request->input('maturityAmmount');
        $fixDeposit->holding_type = $request->input('holdingType');
        $fixDeposit->joint_holder_name = $request->input('jointHolderName');
        $fixDeposit->joint_holder_pan = $request->input('jointHolderPan');
        $fixDeposit->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $fixDeposit->image = $fdFileNameToStore;
         } 
        $fixDeposit->save();
    
        if($request->has('nominees')) {
            $nominee_id = $request->input('nominees');
            if(is_string($nominee_id)) {
                $nominee_id = explode(',', $nominee_id);
            }
            if(is_array($nominee_id)) {
                $nominee_id = array_map('intval', $nominee_id);
                $fixDeposit->nominee()->attach($nominee_id);
            }
        }

        return $this->sendResponse(['FixDeposite'=> new FixDepositeResource($fixDeposit)], 'Fix deposite details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $fixDeposit = FixDeposite::find($id);
        if(!$fixDeposit){
            return $this->sendError('Fix Deposite Not Found',['error'=>'fix Deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $fixDeposit->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Fix Deposite']);
         }
         $fixDeposit->load('nominee');
        return $this->sendResponse(['FixDeposite'=>new FixDepositeResource($fixDeposit)], 'Fix Deposite retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFixDepositRequest $request, string $id): JsonResponse
    {
        $fixDeposit = FixDeposite::find($id);
        if(!$fixDeposit){
            return $this->sendError('Fix deposite Not Found',['error'=>'fix deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $fixDeposit->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Fix Deposite']);
         }
         
        if($request->hasFile('image')){
            if(!empty($fixDeposit->image) && Storage::exists('public/FixDeposite/'.$fixDeposit->image)) {
                Storage::delete('public/FixDeposite/'.$fixDeposit->image);
            }
            $fdFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $fdFilename = pathinfo($fdFileNameWithExtention, PATHINFO_FILENAME);
            $fdExtention = $request->file('image')->getClientOriginalExtension();
            $fdFileNameToStore = $fdFilename.'_'.time().'.'.$fdExtention;
            $fdPath = $request->file('image')->storeAs('public/FixDeposite', $fdFileNameToStore);
         }
       
         $fixDeposit->fix_deposite_number = $request->input('fixDepositeNumber');
         $fixDeposit->bank_name = $request->input('bankName');
         $fixDeposit->branch_name = $request->input('branchName');
         $fixDeposit->maturity_date = $request->input('maturityDate');
         $fixDeposit->maturity_ammount = $request->input('maturityAmmount');
         $fixDeposit->holding_type = $request->input('holdingType');
         $fixDeposit->joint_holder_name = $request->input('jointHolderName');
         $fixDeposit->joint_holder_pan = $request->input('jointHolderPan');
         $fixDeposit->additional_details = $request->input('additionalDetails');
         if($request->hasFile('image')){
             $fixDeposit->image = $fdFileNameToStore;
          } 
         $fixDeposit->save();

         if($request->has('nominees')) {
            $nominee_id = is_string($request->input('nominees')) 
            ? explode(',', $request->input('nominees')) 
            : $request->input('nominees');
            $nominee_id = array_map('intval', $nominee_id);
            $fixDeposit->nominee()->sync($nominee_id);
         }else {
             $fixDeposit->nominee()->detach();
        }

         return $this->sendResponse(['FixDeposite'=> new FixDepositeResource($fixDeposit)], 'Fix deposite details updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $fixDeposit = FixDeposite::find($id);
        if(!$fixDeposit){
            return $this->sendError('Fix deposite not found', ['error'=>'Fix deposite not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $fixDeposit->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Fix deposite']);
        }

        if(!empty($fixDeposit->image) && Storage::exists('public/FixDeposite/'.$fixDeposit->image)) {
            Storage::delete('public/FixDeposite/'.$fixDeposit->image);
        }

        $fixDeposit->delete();

        return $this->sendResponse([], 'Fix deposite deleted successfully');
    }
}