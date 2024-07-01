<?php

namespace App\Http\Controllers\Api;

use App\Models\OtherAsset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OtherAssetResource;
use App\Http\Controllers\Api\BaseController;

class OtherAssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $vehicle = $user->profile->otherAsset()->where('type', 'vehicle')->get();
        $huf = $user->profile->otherAsset()->where('type', 'huf')->get();
        $jewellery = $user->profile->otherAsset()->where('type', 'jewellery')->get();
        $watch = $user->profile->otherAsset()->where('type', 'watch')->get();
        $artifact = $user->profile->otherAsset()->where('type', 'artifact')->get();
        $digitalAsset = $user->profile->otherAsset()->where('type', 'digitalAsset')->get();
        $otherAsset = $user->profile->otherAsset()->where('type', 'otherAsset')->get();
        $recoverable = $user->profile->otherAsset()->where('type', 'recoverable')->get();

        return $this->sendResponse(['Vehicle'=>OtherAssetResource::collection($vehicle),'HUF'=>OtherAssetResource::collection($huf),'Jewellery'=>OtherAssetResource::collection($jewellery),'Watch'=>OtherAssetResource::collection($watch),'Artifact'=>OtherAssetResource::collection($artifact),'DigitalAsset'=>OtherAssetResource::collection($digitalAsset),'OtherAsset'=>OtherAssetResource::collection($otherAsset),'Recoverable'=>OtherAssetResource::collection($recoverable)], "Other Assets retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $jewelleryNames[] = null;
        if($request->hasFile('jewelleryImages')){
            foreach($request->file('jewelleryImages') as $image){
            $jewelleryfileNameWithExt = $image->getClientOriginalName();
            $jewelleryfilename = pathinfo($jewelleryfileNameWithExt, PATHINFO_FILENAME);
            $jewelleryExtention = $image->getClientOriginalExtension();
            $jewelleryFileNameToStore = $jewelleryfilename.'_'.time().'.'.$jewelleryExtention;
            $jewelleryPath = $image->storeAs('public/OtherAsset/jewelleryImages', $jewelleryFileNameToStore);
            $jewelleryNames[] = $jewelleryFileNameToStore;
          }
        }
        $jewelleryImages  = json_encode($jewelleryNames);

        $watchNames[] = null;
        if($request->hasFile('watchImages')){
            foreach($request->file('watchImages') as $image){
            $watchfileNameWithExt = $image->getClientOriginalName();
            $watchfilename = pathinfo($watchfileNameWithExt, PATHINFO_FILENAME);
            $watchExtention = $image->getClientOriginalExtension();
            $watchFileNameToStore = $watchfilename.'_'.time().'.'.$watchExtention;
            $watchPath = $image->storeAs('public/OtherAsset/watchImages', $watchFileNameToStore);
            $watchNames[] = $watchFileNameToStore;
          }
        }
        $watchImages  = json_encode($watchNames);

        $artifactNames[] = null;
        if($request->hasFile('artifactImages')){
            foreach($request->file('artifactImages') as $image){
            $artifactfileNameWithExt = $image->getClientOriginalName();
            $artifactfilename = pathinfo($artifactfileNameWithExt, PATHINFO_FILENAME);
            $artifactExtention = $image->getClientOriginalExtension();
            $artifactFileNameToStore = $artifactfilename.'_'.time().'.'.$artifactExtention;
            $artifactPath = $image->storeAs('public/OtherAsset/artifactImages', $artifactFileNameToStore);
            $artifactNames[] = $artifactFileNameToStore;
          }
        }
        $artifactImages  = json_encode($artifactNames);

        $otherNames[] = null;
        if($request->hasFile('otherAssetImages')){
            foreach($request->file('otherAssetImages') as $image){
            $otherfileNameWithExt = $image->getClientOriginalName();
            $otherfilename = pathinfo($artifactfileNameWithExt, PATHINFO_FILENAME);
            $otherExtention = $image->getClientOriginalExtension();
            $otherFileNameToStore = $otherfilename.'_'.time().'.'.$otherExtention;
            $otherPath = $image->storeAs('public/OtherAsset/otherAssetImages', $otherFileNameToStore);
            $otherNames[] = $otherFileNameToStore;
          }
        }
        $otherImages  = json_encode($otherNames);

        $user = Auth::user();
        $otherAsset = new OtherAsset();
        $otherAsset->profile_id = $user->profile->id;
        $otherAsset->type = $request->input('type');
        $otherAsset->vehicle_type = $request->input('vehicleType');
        $otherAsset->four_wheeler = $request->input('fourWheeler');
        $otherAsset->company = $request->input('company');
        $otherAsset->model = $request->input('model');
        $otherAsset->registration_number = $request->input('registrationNumber');
        $otherAsset->year_of_manufacture = $request->input('yearOfManufacture');
        $otherAsset->location = $request->input('location');
        $otherAsset->huf_name = $request->input('hufName');
        $otherAsset->pan_number = $request->input('panNumber');
        $otherAsset->huf_share = $request->input('hufShare');
        $otherAsset->jewellery_type = $request->input('jewelleryType');
        $otherAsset->metal = $request->input('metal');
        $otherAsset->precious_stone = $request->input('preciousStone');
        $otherAsset->weight_per_jewellery = $request->input('weightPerJewellery');
        $otherAsset->quantity = $request->input('quantity');
        $otherAsset->type_of_artifacts = $request->input('typeOfArtifacts');
        $otherAsset->artist_name = $request->input('artistName');
        $otherAsset->painting_name = $request->input('paintingName');
        $otherAsset->number_of_articles = $request->input('numberOfArticles');
        $otherAsset->digital_assets = $request->input('digitalAssets');
        $otherAsset->account = $request->input('account');
        $otherAsset->linked_mobile_number = $request->input('linkedMobileNumber');
        $otherAsset->description = $request->input('description');
        $otherAsset->name_of_asset = $request->input('nameOfAsset');
        $otherAsset->asset_description = $request->input('assetDescription');
        $otherAsset->name_of_borrower = $request->input('nameOfBorrower');
        $otherAsset->address = $request->input('address');
        $otherAsset->contact_number = $request->input('contactNumber');
        $otherAsset->mode_of_loan = $request->input('modeOfLoan');
        $otherAsset->ammount = $request->input('ammount');
        $otherAsset->due_date = $request->input('dueDate');
        $otherAsset->additional_information = $request->input('additionalInformation');
        $otherAsset->jewellery_images = $request->input('jewelleryImages');
        if($request->hasFile('jewelleryImages')){
            $otherAsset->jewellery_images = $jewelleryImages;
        }
        if($request->hasFile('watchImages')){
            $otherAsset->watch_images = $watchImages;
        }
        if($request->hasFile('artifactImages')){
            $otherAsset->artifact_images = $artifactImages;
        }
        if($request->hasFile('otherAssetImages')){
            $otherAsset->other_asset_images = $otherImages;
        }
        $otherAsset->name = $request->input('name');
        $otherAsset->mobile = $request->input('mobile');
        $otherAsset->email = $request->input('email');
        $otherAsset->save();

        return $this->sendResponse(['OtherAsset'=> new OtherAssetResource($otherAsset)], 'Other Assets details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $otherAsset = OtherAsset::find($id);
        if(!$otherAsset){
            return $this->sendError('Other Asset Not Found',['error'=>'Other Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Asset']);
         }
        return $this->sendResponse(['OtherAsset'=>new OtherAssetResource($otherAsset)], 'Other Asset retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $otherAsset = OtherAsset::find($id);
        if(!$otherAsset){
            return $this->sendError('Other Asset Not Found',['error'=>'Other Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherAsset->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Asset']);
         }
         $otherAsset->type = $request->input('type');
         $otherAsset->vehicle_type = $request->input('vehicleType');
         $otherAsset->four_wheeler = $request->input('fourWheeler');
         $otherAsset->company = $request->input('company');
         $otherAsset->model = $request->input('model');
         $otherAsset->registration_number = $request->input('registrationNumber');
         $otherAsset->year_of_manufacture = $request->input('yearOfManufacture');
         $otherAsset->location = $request->input('location');
         $otherAsset->huf_name = $request->input('hufName');
         $otherAsset->pan_number = $request->input('panNumber');
         $otherAsset->huf_share = $request->input('hufShare');
         $otherAsset->jewellery_type = $request->input('jewelleryType');
         $otherAsset->metal = $request->input('metal');
         $otherAsset->precious_stone = $request->input('preciousStone');
         $otherAsset->weight_per_jewellery = $request->input('weightPerJewellery');
         $otherAsset->quantity = $request->input('quantity');
         $otherAsset->type_of_artifacts = $request->input('typeOfArtifacts');
         $otherAsset->artist_name = $request->input('artistName');
         $otherAsset->painting_name = $request->input('paintingName');
         $otherAsset->number_of_articles = $request->input('numberOfArticles');
         $otherAsset->digital_assets = $request->input('digitalAssets');
         $otherAsset->account = $request->input('account');
         $otherAsset->linked_mobile_number = $request->input('linkedMobileNumber');
         $otherAsset->description = $request->input('description');
         $otherAsset->name_of_asset = $request->input('nameOfAsset');
         $otherAsset->asset_description = $request->input('assetDescription');
         $otherAsset->name_of_borrower = $request->input('nameOfBorrower');
         $otherAsset->address = $request->input('address');
         $otherAsset->contact_number = $request->input('contactNumber');
         $otherAsset->mode_of_loan = $request->input('modeOfLoan');
         $otherAsset->amount = $request->input('amount');
         $otherAsset->due_date = $request->input('dueDate');
         $otherAsset->additional_information = $request->input('additionalInformation');
         $otherAsset->jewellery_images = $request->input('jewelleryImages');
         $otherAsset->watch_images = $request->input('watchImages');
         $otherAsset->artifact_images = $request->input('artifactImages');
         $otherAsset->other_asset_images = $request->input('otherAssetImages');
         $otherAsset->name = $request->input('name');
         $otherAsset->mobile = $request->input('mobile');
         $otherAsset->email = $request->input('email');
         $otherAsset->save();

         return $this->sendResponse(['OtherAsset'=>new OtherAssetResource($otherAsset)], 'Other Asset updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $otherAsset = OtherAsset::find($id);
        if(!$otherAsset){
            return $this->sendError('Other Asset not found', ['error'=>'Other Asset not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherAsset->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Other Asset']);
        }
        $otherAsset->delete();

        return $this->sendResponse([], 'Other Asset deleted successfully');
    }
}
