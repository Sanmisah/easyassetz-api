<?php

namespace App\Http\Controllers\Api;

use App\Models\DigitalAsset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\DigitalAssetResource;

class DigitalAssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $digitalAsset = $user->profile->digitalAsset()->get();
        return $this->sendResponse(['DigitalAsset'=>DigitalAssetResource::collection($digitalAsset)],'Digital Assets retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $digitalAsset = new DigitalAsset();
        $digitalAsset->profile_id = $user->profile->id;
        $digitalAsset->digital_asset = $request->input('digitalAsset');
        $digitalAsset->account = $request->input('account');
        $digitalAsset->linked_mobile_number = $request->input('linkedMobileNumber');
        $digitalAsset->description = $request->input('description');
        $digitalAsset->additional_information = $request->input('additionalInformation');
        $digitalAsset->name = $request->input('name');
        $digitalAsset->mobile = $request->input('mobile');
        $digitalAsset->email = $request->input('email');
        $digitalAsset->save();

        return $this->sendResponse(['DigitalAsset'=> new DigitalAssetResource($digitalAsset)], 'Digital Assets details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $digitalAsset = DigitalAsset::find($id);
        if(!$digitalAsset){
            return $this->sendError('Digital Assets Not Found',['error'=>'Digital Assets not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $digitalAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Digital Assets']);
         }

        return $this->sendResponse(['DigitalAsset'=>new DigitalAssetResource($digitalAsset)], 'Digital Assets retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $digitalAsset = DigitalAsset::find($id);
        if(!$digitalAsset){
            return $this->sendError('Digital Assets Not Found',['error'=>'Demat Account not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $digitalAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Digital Assets']);
         }

         $digitalAsset->digital_asset = $request->input('digitalAsset');
         $digitalAsset->account = $request->input('account');
         $digitalAsset->linked_mobile_number = $request->input('linkedMobileNumber');
         $digitalAsset->description = $request->input('description');
         $digitalAsset->additional_information = $request->input('additionalInformation');
         $digitalAsset->name = $request->input('name');
         $digitalAsset->mobile = $request->input('mobile');
         $digitalAsset->email = $request->input('email');
         $digitalAsset->save();

         return $this->sendResponse(['DigitalAsset'=> new DigitalAssetResource($digitalAsset)], 'Digital Assets details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $digitalAsset = DigitalAsset::find($id);
        if(!$digitalAsset){
            return $this->sendError('Digital Assets not found', ['error'=>'Digital Assets not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $digitalAsset->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Digital Assets']);
        }
        $digitalAsset->delete();

        return $this->sendResponse([], 'Digital Assets deleted successfully');
    }
}
