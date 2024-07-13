<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\InvestmentFund;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AlternateInvestmentFundResource;
use App\Http\Controllers\Api\AlternateInvestmentFundController;

class AlternateInvestmentFundController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $user = Auth::user();
        $investmentFund = $user->profile->investmentFund()->with('nominee')->get();
        return $this->sendResponse(['InvestmentFund'=>AlternateInvestmentFundResource::collection($investmentFund)],'alternate investment fund details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResource
    {
        if($request->hasFile('investmentFund')){
            $fundFileNameWithExtention = $request->file('investmentFund')->getClientOriginalName();
            $fundFilename = pathinfo($fundFileNameWithExtention, PATHINFO_FILENAME);
            $fundExtention = $request->file('investmentFund')->getClientOriginalExtension();
            $fundFileNameToStore = $fundFilename.'_'.time().'.'.$fundExtention;
            $fundPath = $request->file('investmentFund')->storeAs('public/InvestmentFund', $fundFileNameToStore);
         }

        $user = Auth::user();
        $investmentFund = new InvestmentFund();
        $investmentFund->profile_id = $user->profile->id;
        $investmentFund->fund_name = $request->input('fundName');
        $investmentFund->folio_number = $request->input('folioNumber');
        $investmentFund->nature_of_holding = $request->input('natureOfHolding');
        $investmentFund->joint_holder_name = $request->input('jointHolderName');
        $investmentFund->joint_holder_pan = $request->input('jointHolderPan');
        $investmentFund->additional_details = $request->input('additionalDetails');
        if($request->hasFile('investmentFund')){
            $investmentFund->image = $fundFileNameToStore;
         } 
        $investmentFund->name = $request->input('name');
        $investmentFund->mobile = $request->input('mobile');
        $investmentFund->email = $request->input('email');
        $investmentFund->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $investmentFund->nominee()->attach($nominee_id);
        }


        return $this->sendResponse(['InvestmentFund'=> new AlternateInvestmentFundResource($investmentFund)], 'Alternate Investment Fund details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResource
    {
        $investmentFund = InvestmentFund::find($id);
        if(!$investmentFund){
            return $this->sendError('alternate investment fund Not Found',['error'=>'Alternate investment fund not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $investmentFund->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this alternate investment fund']);
         }
         $investmentFund->load('nominee');
        return $this->sendResponse(['InvestmentFund'=>new AlternateInvestmentFundResource($investmentFund)], 'Alternate Investment Fund retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResource
    {

        if($request->hasFile('investmentFund')){
            $fundFileNameWithExtention = $request->file('investmentFund')->getClientOriginalName();
            $fundFilename = pathinfo($fundFileNameWithExtention, PATHINFO_FILENAME);
            $fundExtention = $request->file('investmentFund')->getClientOriginalExtension();
            $fundFileNameToStore = $fundFilename.'_'.time().'.'.$fundExtention;
            $fundPath = $request->file('investmentFund')->storeAs('public/InvestmentFund', $fundFileNameToStore);
         }

        $investmentFund = InvestmentFund::find($id);
        if(!$investmentFund){
            return $this->sendError('alternate investment fund Not Found',['error'=>'alternate investment fund not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $investmentFund->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this alternate investment fund']);
         }

         $investmentFund->fund_name = $request->input('fundName');
         $investmentFund->folio_number = $request->input('folioNumber');
         $investmentFund->nature_of_holding = $request->input('natureOfHolding');
         $investmentFund->joint_holder_name = $request->input('jointHolderName');
         $investmentFund->joint_holder_pan = $request->input('jointHolderPan');
         $investmentFund->additional_details = $request->input('additionalDetails');
         if($request->hasFile('investmentFund')){
             $investmentFund->image = $fundFileNameToStore;
          } 
         $investmentFund->name = $request->input('name');
         $investmentFund->mobile = $request->input('mobile');
         $investmentFund->email = $request->input('email');
         $investmentFund->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $investmentFund->nominee()->sync($nominee_ids);
        }else {
            $investmentFund->nominee()->detach();
        }

         return $this->sendResponse(['InvestmentFund'=> new AlternateInvestmentFundResource($investmentFund)], 'alternate Investment Fund details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResource
    {
        $investmentFund = InvestmentFund::find($id);
        if(!$investmentFund){
            return $this->sendError('Alternate investment fund not found', ['error'=>'Alternate investment fund not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $investmentFund->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this alternate Investment fund']);
        }
        Storage::delete('public/InvestmentFund/'.$investmentFund->image);
        $investmentFund->delete();

        return $this->sendResponse([], 'Alternate investment fund deleted successfully');
    }
    
}
