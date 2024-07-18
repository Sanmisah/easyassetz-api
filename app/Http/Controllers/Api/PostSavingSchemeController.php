<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PostSavingScheme;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\PostSavingSchemeResource;
use App\Http\Requests\StorePostSavingSchemeRequest;
use App\Http\Requests\UpdatePostSavingSchemeRequest;

class PostSavingSchemeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $postSavingScheme = $user->profile->postSavingScheme()->with('nominee')->get();
        return $this->sendResponse(['PostSavingScheme'=>PostSavingSchemeResource::collection($postSavingScheme)],'Post Saving Scheme details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostSavingSchemeRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $imageFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFileNameWithExtention, PATHINFO_FILENAME);
            $imageExtention = $request->file('image')->getClientOriginalExtension();
            $imageFileNameToStore = $imageFilename.'_'.time().'.'.$imageExtention;
            $imagePath = $request->file('image')->storeAs('public/PostSavingScheme', $imageFileNameToStore);
         }

         $user = Auth::user();
         $postSavingScheme = new PostSavingScheme();
         $postSavingScheme->profile_id = $user->profile->id;
         $postSavingScheme->type = $request->input('type');
         $postSavingScheme->certificate_number = $request->input('certificate_number');
         $postSavingScheme->maturity_date = $request->input('maturity_date');
         $postSavingScheme->amount = $request->input('amount');
         $postSavingScheme->holding_type = $request->input('holding_type');
         $postSavingScheme->joint_holder_name = $request->input('jointHolderName');
         $postSavingScheme->joint_holder_pan = $request->input('jointHolderPan');
         $postSavingScheme->additional_details = $request->input('additional_details');
         if($request->hasFile('image')){
            $postSavingScheme->image = $imageFileNameToStore;
         } 
         $postSavingScheme->name = $request->input('name');
         $postSavingScheme->mobile = $request->input('mobile');
         $postSavingScheme->email = $request->input('email');
         $postSavingScheme->save();       

         if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $postSavingScheme->nominee()->attach($nominee_id);
        }
        return $this->sendResponse(['PostSavingScheme'=> new PostSavingSchemeResource($postSavingScheme)], 'Post Saving Scheme details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $postSavingScheme = PostSavingScheme::find($id);
        if(!$postSavingScheme){
            return $this->sendError('Post Saving Scheme Not Found',['error'=>'Postal Saving Scheme details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $postSavingScheme->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Postal saving Scheme details']);
         }
         $postSavingScheme->load('nominee');
        return $this->sendResponse(['PostSavingScheme'=>new PostSavingSchemeResource($postSavingScheme)], 'Post Saving Scheme details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostSavingSchemeRequest $request, string $id)
    {
        if($request->hasFile('image')){
            $imageFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $imageFilename = pathinfo($imageFileNameWithExtention, PATHINFO_FILENAME);
            $imageExtention = $request->file('image')->getClientOriginalExtension();
            $imageFileNameToStore = $imageFilename.'_'.time().'.'.$imageExtention;
            $imagePath = $request->file('image')->storeAs('public/PostSavingScheme', $imageFileNameToStore);
         }

         $postSavingScheme->type = $request->input('type');
         $postSavingScheme->certificate_number = $request->input('certificate_number');
         $postSavingScheme->maturity_date = $request->input('maturity_date');
         $postSavingScheme->amount = $request->input('amount');
         $postSavingScheme->holding_type = $request->input('holding_type');
         $postSavingScheme->joint_holder_name = $request->input('jointHolderName');
         $postSavingScheme->joint_holder_pan = $request->input('jointHolderPan');
         $postSavingScheme->additional_details = $request->input('additional_details');
         if($request->hasFile('image')){
            $postSavingScheme->image = $imageFileNameToStore;
         } 
         $postSavingScheme->name = $request->input('name');
         $postSavingScheme->mobile = $request->input('mobile');
         $postSavingScheme->email = $request->input('email');
         $postSavingScheme->save();       

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $postSavingScheme->nominee()->sync($nominee_ids);
        }else {
            $postSavingScheme->nominee()->detach();
        }
       
        return $this->sendResponse(['PostSavingScheme'=>new PostSavingSchemeResource($postSavingScheme)], 'Postal Saving Scheme details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postSavingScheme = PostSavingScheme::find($id);
        if(!$postSavingScheme){
            return $this->sendError('Post Saving Scheme not found', ['error'=>'Post Saving Scheme not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $postSavingScheme->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Post Saving Scheme']);
        }

        if(!empty($postSavingScheme->image) && Storage::exists('public/PostSavingScheme/'.$postSavingScheme->image)) {
            Storage::delete('public/PostSavingScheme/'.$postSavingScheme->image);
        }
        
        $postSavingScheme->delete();

        return $this->sendResponse([], 'Post Saving Scheme deleted successfully');
    }
    
}
