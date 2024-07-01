<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BankAccountResource;
use App\Http\Controllers\Api\BaseController;

class BankAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $bankAccount = $user->profile->bankAccount()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['BankAccount'=>BankAccountResource::collection($bankAccount)],'Bank Account details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        
        if($request->hasFile('image')){
            $bankFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $bankFilename = pathinfo($bankFileNameWithExtention, PATHINFO_FILENAME);
            $bankExtention = $request->file('image')->getClientOriginalExtension();
            $bankFileNameToStore = $bankFilename.'_'.time().'.'.$bankExtention;
            $bankPath = $request->file('image')->storeAs('public/BankAccount', $bankFileNameToStore);
         }

        $user = Auth::user();
        $bankAccount = new BankAccount();
        $bankAccount->profile_id = $user->profile->id;
        $bankAccount->fund_name = $request->input('bankName');
        $bankAccount->account_type = $request->input('accountType');
        $bankAccount->account_number = $request->input('accountNumber');
        $bankAccount->branch_name = $request->input('branchName');
        $bankAccount->city = $request->input('city');
        $bankAccount->holding_type = $request->input('holdingType');
        $bankAccount->joint_holders_pan = $request->input('jointHoldersPan');
        if($request->hasFile('image')){
            $bankAccount->image = $bankFileNameToStore;
         } 
        $bankAccount->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $bankAccount->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $bankAccount->jointHolder()->attach($joint_holder_id);
        }

        return $this->sendResponse(['BankAccount'=> new BankAccountResource($bankAccount)], 'bank Account details stored successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $bankAccount = BankAccount::find($id);
        if(!$bankAccount){
            return $this->sendError('Bank Account fund Not Found',['error'=>'Bank Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bankAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bank Account']);
         }
         $bankAccount->load('nominee','jointHolder');
        return $this->sendResponse(['BankAccount'=>new BankAccountResource($bankAccount)], 'bank Account details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {

        if($request->hasFile('image')){
            $bankFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $bankFilename = pathinfo($bankFileNameWithExtention, PATHINFO_FILENAME);
            $bankExtention = $request->file('image')->getClientOriginalExtension();
            $bankFileNameToStore = $bankFilename.'_'.time().'.'.$bankExtention;
            $bankPath = $request->file('image')->storeAs('public/BankAccount', $bankFileNameToStore);
         }

        $bankAccount = BankAccount::find($id);
        if(!$bankAccount){
            return $this->sendError('Bank Account fund Not Found',['error'=>'Bank Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bankAccount->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Bank Account']);
         }
          

         $bankAccount->fund_name = $request->input('bankName');
         $bankAccount->account_type = $request->input('accountType');
         $bankAccount->account_number = $request->input('accountNumber');
         $bankAccount->branch_name = $request->input('branchName');
         $bankAccount->city = $request->input('city');
         $bankAccount->holding_type = $request->input('holdingType');
         $bankAccount->joint_holders_pan = $request->input('jointHoldersPan');
         if($request->hasFile('image')){
             $bankAccount->image = $bankFileNameToStore;
          } 
         $bankAccount->save();
 
         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $bankAccount->nominee()->sync($nominee_ids);
        }else {
            $bankAccount->nominee()->detach();
        }

        if($request->has('jointHolder')) {
            $joint_holder_id = $request->input('jointHolder');
            $bankAccount->jointHolder()->sync($joint_holder_id);
        }else {
            $bankAccount->jointHolder()->detach();
        }
 
         return $this->sendResponse(['BankAccount'=> new BankAccountResource($bankAccount)], 'bank Account details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $bankAccount = BankAccount::find($id);
        if(!$bankAccount){
            return $this->sendError('Bank Account not found', ['error'=>'Bank Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $bankAccount->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Bank Account']);
        }
        $bankAccount->delete();

        return $this->sendResponse([], 'bank Account fund deleted successfully');
    }
}
