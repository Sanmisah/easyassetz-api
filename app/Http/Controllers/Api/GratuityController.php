<?php

namespace App\Http\Controllers\Api;

use App\Models\NPS;
use App\Models\Gratuity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\GratuityResource;
use App\Http\Requests\StoreGratuityRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdateGratuityRequest;

class GratuityController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $gratuity = $user->profile->gratuity()->with('nominee')->get();
    
        return $this->sendResponse(['Gratuity'=>GratuityResource::collection($gratuity)], "Gratuity details retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGratuityRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $gratuityFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $gratuityFilename = pathinfo($gratuityFileNameWithExtention, PATHINFO_FILENAME);
            $gratuityExtention = $request->file('image')->getClientOriginalExtension();
            $gratuityFileNameToStore = $gratuityFilename.'_'.time().'.'.$gratuityExtention;
            $gratuityPath = $request->file('image')->storeAs('public/Gratuity', $gratuityFileNameToStore);
         }

        $user = Auth::user();
        $gratuity = new Gratuity();
        $gratuity->profile_id = $user->profile->id;
        $gratuity->employer_name = $request->input('employerName');
        $gratuity->employer_id = $request->input('employerId');
        $gratuity->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $gratuity->image = $gratuityFileNameToStore;
         }     
        $gratuity->name = $request->input('name');
        $gratuity->mobile = $request->input('mobile');
        $gratuity->email = $request->input('email');
        $gratuity->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $gratuity->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['Gratuity'=> new GratuityResource($gratuity)], 'Gratuity details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $gratuity = Gratuity::find($id);
        if(!$gratuity){
            return $this->sendError('Gratuity Not Found',['error'=>'Gratuity not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $gratuity->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Gratuity']);
         }
         $gratuity->load('nominee');
        return $this->sendResponse(['Gratuity'=>new GratuityResource($gratuity)], 'Gratuity details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGratuityRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $gratuityFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $gratuityFilename = pathinfo($gratuityFileNameWithExtention, PATHINFO_FILENAME);
            $gratuityExtention = $request->file('image')->getClientOriginalExtension();
            $gratuityFileNameToStore = $gratuityFilename.'_'.time().'.'.$gratuityExtention;
            $gratuityPath = $request->file('image')->storeAs('public/Gratuity', $gratuityFileNameToStore);
         }

         $gratuity = Gratuity::find($id);
         if(!$gratuity){
             return $this->sendError('Gratuity Not Found',['error'=>'Gratuity details not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $gratuity->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Gratuity']);
          }

          $gratuity->employer_name = $request->input('employerName');
          $gratuity->employer_id = $request->input('employerId');
          $gratuity->additional_details = $request->input('additionalDetails');
          if($request->hasFile('image')){
              $gratuity->image = $gratuityFileNameToStore;
           }     
          $gratuity->name = $request->input('name');
          $gratuity->mobile = $request->input('mobile');
          $gratuity->email = $request->input('email');
          $gratuity->save();
  
          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $gratuity->nominee()->sync($nominee_ids);
        }else {
            $gratuity->nominee()->detach();
        }

         return $this->sendResponse(['Gratuity'=> new GratuityResource($gratuity)], 'Gratuity details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $gratuity = Gratuity::find($id);
        if(!$gratuity){
            return $this->sendError('Gratuity not found', ['error'=>'Gratuity not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $gratuity->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Gratuity']);
        }

        if(!empty($gratuity->image) && Storage::exists('public/Gratuity/'.$gratuity->image)) {
            Storage::delete('public/Gratuity/'.$gratuity->image);
        }
        
        $gratuity->delete();

        return $this->sendResponse([], 'Gratuity deleted successfully');
    }
}
