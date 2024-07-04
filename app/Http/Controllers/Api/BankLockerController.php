<?php

namespace App\Http\Controllers\Api;

use App\Models\BankLocker;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BankLockerResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreBankLockerRequest;
use App\Http\Requests\UpdateBankLockerRequest;

class BankLockerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $bankLocker = $user->profile->bankLocker()->with('nominee')->get();
        return $this->sendResponse(['BankLocker'=>BankLockerResource::collection($bankLocker)],'Bank lockers details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankLockerRequest $request): JsonResponse
    {
        if($request->hasFile('bankLockerImage')){
            $bankFileNameWithExtention = $request->file('bankLockerImage')->getClientOriginalName();
            $bankFilename = pathinfo($bankFileNameWithExtention, PATHINFO_FILENAME);
            $bankExtention = $request->file('bankLockerImage')->getClientOriginalExtension();
            $bankFileNameToStore = $bankFilename.'_'.time().'.'.$bankExtention;
            $bankPath = $request->file('bankLockerImage')->storeAs('public/BankLocker', $bankFileNameToStore);
         }

        $user = Auth::user();
        $bankLocker = new BankLocker();
        $bankLocker->profile_id = $user->profile->id;
        $bankLocker->bank_name = $request->input('bankName');
        $bankLocker->branch = $request->input('branch');
        $bankLocker->locker_number = $request->input('lockerNnumber');
        $bankLocker->nature_of_holding = $request->input('natureOfHolding');
        $bankLocker->joint_holder_name = $request->input('jointHolderName');
        $bankLocker->joint_holder_pan = $request->input('jointHolderPan');
        $bankLocker->rent_due_date = $request->input('rentDueDate');
        $bankLocker->annual_rent = $request->input('annualRent');
        $bankLocker->additional_details = $request->input('additionalDetails');
        if($request->hasFile('bankLockerImage')){
            $bankLocker->image = $bankFileNameToStore;
         } 
        $bankLocker->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $bankLocker->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['BankLocker'=> new BankLockerResource($bankLocker)], 'Bank Locker details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $bankLocker = BankLocker::find($id);
        if(!$bankLocker){
            return $this->sendError('Bank Locker Not Found',['error'=>'Bank Locker not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bankLocker->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bank Locker']);
         }
         $bankLocker->load('nominee');
        return $this->sendResponse(['BankLocker'=>new BankLockerResource($bankLocker)], 'Bank Locker Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankLockerRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('bankLockerImage')){
            $bankFileNameWithExtention = $request->file('bankLockerImage')->getClientOriginalName();
            $bankFilename = pathinfo($bankFileNameWithExtention, PATHINFO_FILENAME);
            $bankExtention = $request->file('bankLockerImage')->getClientOriginalExtension();
            $bankFileNameToStore = $bankFilename.'_'.time().'.'.$bankExtention;
            $bankPath = $request->file('bankLockerImage')->storeAs('public/BankLocker', $bankFileNameToStore);
         }

         $bankLocker = BankLocker::find($id);
         if(!$bankLocker){
             return $this->sendError('Bank Locker Not Found',['error'=>'Bank Locker not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $bankLocker->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bank Locker']);
          }

          $bankLocker->bank_name = $request->input('bankName');
          $bankLocker->branch = $request->input('branch');
          $bankLocker->locker_number = $request->input('lockerNnumber');
          $bankLocker->nature_of_holding = $request->input('natureOfHolding');
          $bankLocker->joint_holder_name = $request->input('jointHolderName');
          $bankLocker->joint_holder_pan = $request->input('jointHolderPan');
          $bankLocker->rent_due_date = $request->input('rentDueDate');
          $bankLocker->annual_rent = $request->input('annualRent');
          $bankLocker->additional_details = $request->input('additionalDetails');
          if($request->hasFile('bankLockerImage')){
              $bankLocker->image = $bankFileNameToStore;
           } 
          $bankLocker->save();

            if($request->has('nominees')) {
                $nominee_ids = $request->input('nominees');
                $bankLocker->nominee()->sync($nominee_ids);
            }else {
                $bankLocker->nominee()->detach();
            }

         return $this->sendResponse(['BankLocker'=> new BankLockerResource($bankLocker)], 'Bank Locker details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $fixDeposit = BankLocker::find($id);
        if(!$fixDeposit){
            return $this->sendError('Bank Locker details not found', ['error'=>'Bank Locker details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $fixDeposit->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Bank Locker details']);
        }
        $fixDeposit->delete();

        return $this->sendResponse([], 'Bank Locker details deleted successfully');
    }

}
