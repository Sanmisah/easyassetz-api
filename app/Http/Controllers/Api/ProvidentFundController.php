<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProvidentFund;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ProvidentFundResource;

class ProvidentFundController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $ProvidentFund = $user->profile->providentFund()->with('nominee')->get();
        return $this->sendResponse(['ProvidentFund'=>ProvidentFundResource::collection($ProvidentFund)],'Provident fund details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $pfFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $pfFilename = pathinfo($pfFileNameWithExtention, PATHINFO_FILENAME);
            $pfExtention = $request->file('image')->getClientOriginalExtension();
            $pfFileNameToStore = $pfFilename.'_'.time().'.'.$pfExtention;
            $pfPath = $request->file('image')->storeAs('public/ProvidentFund', $pfFileNameToStore);
         }
         $user = Auth::user();
        $providentFund = new ProvidentFund();
        $providentFund->profile_id = $user->profile->id;
        $providentFund->employer_name = $request->input('employerName');
        $providentFund->uan_number = $request->input('uanNumber');
        $providentFund->bank_name = $request->input('bankName');
        $providentFund->branch = $request->input('branch');
        $providentFund->bank_account_number = $request->input('bankAccountNumber');
        $providentFund->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $providentFund->image = $pfFileNameToStore;
         }         
        $providentFund->name = $request->input('name');
        $providentFund->mobile = $request->input('mobile');
        $providentFund->email = $request->input('email');
        $providentFund->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $providentFund->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['ProvidentFund'=> new ProvidentFundResource($providentFund)], 'Provident Fund details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $providentFund = ProvidentFund::find($id);
        if(!$providentFund){
            return $this->sendError('Provident fund Not Found',['error'=>'Provident fund not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $providentFund->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Provident fund']);
         }
         $providentFund->load('nominee');
        return $this->sendResponse(['ProvidentFund'=>new ProvidentFundResource($providentFund)], 'Provident Fund retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $pfFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $pfFilename = pathinfo($pfFileNameWithExtention, PATHINFO_FILENAME);
            $pfExtention = $request->file('image')->getClientOriginalExtension();
            $pfFileNameToStore = $pfFilename.'_'.time().'.'.$pfExtention;
            $pfPath = $request->file('image')->storeAs('public/ProvidentFund', $pfFileNameToStore);
         }

         $providentFund = ProvidentFund::find($id);
         if(!$providentFund){
             return $this->sendError('Provident fund Not Found',['error'=>'Provident fund not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $providentFund->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Provident fund']);
          }

          $providentFund->employer_name = $request->input('employerName');
          $providentFund->uan_number = $request->input('uanNumber');
          $providentFund->bank_name = $request->input('bankName');
          $providentFund->branch = $request->input('branch');
          $providentFund->bank_account_number = $request->input('bankAccountNumber');
          $providentFund->additional_details = $request->input('additionalDetails');
          if($request->hasFile('image')){
              $providentFund->image = $pfFileNameToStore;
           }         
          $providentFund->name = $request->input('name');
          $providentFund->mobile = $request->input('mobile');
          $providentFund->email = $request->input('email');
          $providentFund->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $providentFund->nominee()->sync($nominee_ids);
        }else {
            $providentFund->nominee()->detach();
        }

         return $this->sendResponse(['ProvidentFund'=> new ProvidentFundResource($providentFund)], 'Provident Fund details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $providentFund = ProvidentFund::find($id);
        if(!$providentFund){
            return $this->sendError('Provident fund not found', ['error'=>'Provident fund not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $providentFund->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Provident fund']);
        }

        if(!empty($providentFund->image) && Storage::exists('public/ProvidentFund/'.$providentFund->image)) {
            Storage::delete('public/ProvidentFund/'.$providentFund->image);
        }
        
        $providentFund->delete();

        return $this->sendResponse([], 'Provident fund deleted successfully');
    }
}
