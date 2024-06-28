<?php

namespace App\Http\Controllers\Api;

use App\Models\Crypto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CryptoResource;
use App\Http\Resources\LitigationResource;
use App\Http\Controllers\Api\BaseController;

class CryptoController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $crypto = $user->profile->crypto()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['Crypto'=>CryptoResource::collection($crypto)], "Crypto details retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        if($request->hasFile('cryptoFile')){
            $cryptoFileNameWithExtention = $request->file('cryptoFile')->getClientOriginalName();
            $cryptoFilename = pathinfo($cryptoFileNameWithExtention, PATHINFO_FILENAME);
            $cryptoExtention = $request->file('cryptoFile')->getClientOriginalExtension();
            $cryptoFileNameToStore = $cryptoFilename.'_'.time().'.'.$cryptoExtention;
            $cryptoPath = $request->file('cryptoFile')->storeAs('public/profiles/cryptoFiles', $cryptoFileNameToStore);
         }

        $user = Auth::user();
        $crypto = new Crypto();
        $crypto->profile_id = $user->profile->id;
        $crypto->crypto_wallet_type = $request->input('cryptoWalletType');
        $crypto->crypto_wallet_address = $request->input('cryptoWalletAddress');
        $crypto->holding_type = $request->input('holdingType');
        $crypto->exchange = $request->input('exchange');
        $crypto->trading_account = $request->input('tradingAccount');
        $crypto->type_of_currency = $request->input('typeOfCurrency');
        $crypto->holding_qty = $request->input('holdingQty');
        $crypto->additional_details = $request->input('additionalDetails');
        if($request->hasFile('cryptoFile')){
            $crypto->image = $cryptoFileNameToStore;
        }
        $crypto->name = $request->input('name');
        $crypto->mobile = $request->input('mobile');
        $crypto->email = $request->input('email');
        $crypto->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $crypto->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $crypto->jointHolder()->attach($joint_holder_id);
        }

        return $this->sendResponse(['Crypto'=> new CryptoResource($crypto)], 'Crypto details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $crypto = Crypto::find($id);
        if(!$crypto){
            return $this->sendError('Crypto Not Found',['error'=>'Crypto not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $crypto->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Crypto']);
         }
         $crypto->load('nominee','jointHolder');
        return $this->sendResponse(['Crypto'=>new LitigationResource($crypto)], 'Crypto retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
          
        if($request->hasFile('cryptoFile')){
            $cryptoFileNameWithExtention = $request->file('cryptoFile')->getClientOriginalName();
            $cryptoFilename = pathinfo($cryptoFileNameWithExtention, PATHINFO_FILENAME);
            $cryptoExtention = $request->file('cryptoFile')->getClientOriginalExtension();
            $cryptoFileNameToStore = $cryptoFilename.'_'.time().'.'.$cryptoExtention;
            $cryptoPath = $request->file('cryptoFile')->storeAs('public/cryptoFiles', $cryptoFileNameToStore);
         }

        $crypto = Crypto::find($id);
        if(!$crypto){
            return $this->sendError('Crypto Not Found',['error'=>'Crypto not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $crypto->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Crypto']);
         }

         $crypto->crypto_wallet_type = $request->input('cryptoWalletType');
         $crypto->crypto_wallet_address = $request->input('cryptoWalletAddress');
         $crypto->holding_type = $request->input('holdingType');
         $crypto->exchange = $request->input('exchange');
         $crypto->trading_account = $request->input('tradingAccount');
         $crypto->type_of_currency = $request->input('typeOfCurrency');
         $crypto->holding_qty = $request->input('holdingQty');
         $crypto->additional_details = $request->input('additionalDetails');
         if($request->hasFile('cryptoFile')){
            $profile->image = $cryptoFileNameToStore;
         }
         $crypto->name = $request->input('name');
         $crypto->mobile = $request->input('mobile');
         $crypto->email = $request->input('email');
         $crypto->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $crypto->nominee()->sync($nominee_ids);
        }else {
            $crypto->nominee()->detach();
        }

        if($request->has('jointHolder')) {
            $joint_holder_id = $request->input('jointHolder');
            $crypto->jointHolder()->sync($joint_holder_id);
        }else {
            $crypto->jointHolder()->detach();
        }

         return $this->sendResponse(['Crypto'=> new CryptoResource($crypto)], 'Crypto details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $crypto = Crypto::find($id);
        if(!$crypto){
            return $this->sendError('Crypto not found', ['error'=>'Crypto not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $crypto->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Crypto']);
        }
        $crypto->delete();

        return $this->sendResponse([], 'Crypto deleted successfully');
    }
}
