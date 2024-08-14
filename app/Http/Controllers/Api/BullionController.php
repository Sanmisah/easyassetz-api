<?php

namespace App\Http\Controllers\Api;

use App\Models\Bullion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BullionResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBullionRequest;
use App\Http\Requests\UpdateBullionRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\BullionController;

class BullionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        
        $user = Auth::user();
        $bullion = $user->profile->bullion()->get();
        return $this->sendResponse(['Bullion'=>BullionResource::collection($bullion)], "Bullion retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBullionRequest $request): JsonResponse
    {

        if($request->hasFile('bullionFile')){
            $bullionFileNameWithExtention = $request->file('bullionFile')->getClientOriginalName();
            $bullionFilename = pathinfo($bullionFileNameWithExtention, PATHINFO_FILENAME);
            $bullionExtention = $request->file('bullionFile')->getClientOriginalExtension();
            $bullionFileNameToStore = $bullionFilename.'_'.time().'.'.$bullionExtention;
            $bullionPath = $request->file('bullionFile')->storeAs('public/Bullion/', $bullionFileNameToStore);
         }

        
            $user = Auth::user();
            $bullion = new Bullion();
            $bullion->profile_id = $user->profile->id;
            $bullion->metal_type = $request->input('metalType');  
            $bullion->article_details = $request->input('articleDetails');
            $bullion->weight_per_article = $request->input('weightPerArticle');
            $bullion->number_of_articles = $request->input('numberOfArticles');
            $bullion->additional_information = $request->input('additionalInformation');
            $bullion->name = $request->input('name');
            $bullion->mobile = $request->input('mobile');
            $bullion->email = $request->input('email');
            if($request->hasFile('bullionFile')){
                $bullion->image = $bullionFileNameToStore;
            }
            $bullion->save();

            return $this->sendResponse(['Bullion'=> new BullionResource($bullion)], 'Bullion details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $bullion = Bullion::find($id);
        if(!$bullion){
            return$this->sendError('Bullion Not Found' , ['error' => 'Bullion not found']); 
        }
        $user = Auth::user();
        if($user->profile->id !== $bullion->profile_id){
            return $this->sendError('Unauthorized', ['error' => 'You are Not Allowed to view this Bullion']);
        }
        
        return $this->sendResponse(['Bullion' => new BullionResource($bullion)], 'Bullion retrived successfully');
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBullionRequest $request, string $id): JsonResponse
    {
        $bullion = Bullion::find($id);
        if(!$bullion){
            return $this->sendError('Bullion Not Found', ['error'=>'Bullion not found']);     
        }

        $user = Auth::user();
         if($user->profile->id !== $bullion->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Bullion']);
         }

        if($request->hasFile('bullionFile')){

            if(!empty($bullion->image) && Storage::exists('public/Bullion/'.$bullion->image)) {
                Storage::delete('public/Bullion/'.$bullion->image);
            }

            $bullionFileNameWithExtention = $request->file('bullionFile')->getClientOriginalName();
            $bullionFilename = pathinfo($bullionFileNameWithExtention, PATHINFO_FILENAME);
            $bullionExtention = $request->file('bullionFile')->getClientOriginalExtension();
            $bullionFileNameToStore = $bullionFilename.'_'.time().'.'.$bullionExtention;
            $bullionPath = $request->file('bullionFile')->storeAs('public/Bullion', $bullionFileNameToStore);
         }

         $bullion->metal_type = $request->input('metalType');
         $bullion->article_details = $request->input('articleDetails');
         $bullion->weight_per_article = $request->input('weightPerArticle');
         $bullion->number_of_articles = $request->input('numberOfArticles');
         $bullion->additional_information = $request->input('additionalInformation');
         $bullion->name = $request->input('name');
         $bullion->mobile = $request->input('mobile');
         $bullion->email = $request->input('email');
         if($request->hasFile('bullionFile')){
            $bullion->image = $bullionFileNameToStore;
        }
         $bullion->save();
         
         return $this->sendResponse(['Bullion' => new BullionResource($bullion)], 'Bullion updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $bullion = Bullion::find($id);
        if(!$bullion){
        return $this->sendError('Bullion no found', ['error'=>'Bullion not found' ]);
    }
    $user = Auth::user();
    if($user->profile->id !== $bullion->profile_id){
        return $this->sendError('Unauthorized',['error' =>'You are not allowed to access this Bullion' ]);
    }

    if(!empty($bullion->image) && Storage::exists('public/Bullion/'.$bullion->image)) {
        Storage::delete('public/Bullion/'.$bullion->image);
    }
    
    $bullion->delete();

    return $this->sendResponse([], 'Bullion deleted successfully');

    }
}