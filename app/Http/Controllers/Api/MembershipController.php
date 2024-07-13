<?php

namespace App\Http\Controllers\Api;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MembershipResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\MembershipController;

class MembershipController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $membership = $user->profile->membership()->get();
       
        return $this->sendResponse(['Membership'=>MembershipResource::collection($membership)], "Membership retrived successfully");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $membershipFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $membershipFilename = pathinfo($membershipFileNameWithExtention, PATHINFO_FILENAME);
            $membershipExtention = $request->file('image')->getClientOriginalExtension();
            $membershipFileNameToStore = $membershipFilename.'_'.time().'.'.$membershipExtention;
            $membershipPath = $request->file('image')->storeAs('public/Membership', $membershipFileNameToStore);
         }
    
       $user = Auth::user();
     $membership = new Membership();
     $membership->profile_id = $user->profile->id;
     $membership->organization_name = $request->input('organizationName');  
     $membership->membership_id = $request->input('membershipId');
     $membership->membership_type = $request->input('membershipType');
     $membership->membership_payment_date = $request->input('membershipPaymentDate');
     $membership->name = $request->input('name');
     $membership->mobile = $request->input('mobile');
     $membership->email = $request->input('email');
     if($request->hasFile('image')){
        $membership->image = $membershipFileNameToStore;
     }
     $membership->save();

     if($request->has('nominees')){
        $nominee_id = $request->input('nominees');
        $membership->nominee()->attach($nominee_id);
    }


     return $this->sendResponse(['Membership'=> new MembershipResource($membership)], 'Membership details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $membership = Membership::find($id);
        if(!$membership){
            return$this->sendError('Membership Not Found' , ['error' => 'Membership not found']); 
        }
        $user = Auth::user();
        if($user->profile->id !== $membership->profile_id){
            return $this->sendError('Unauthorized', ['error' => 'You are Not Allowed to view this Membership']);
        }
        
        return $this->sendResponse(['Membership' => new MembershipResource($membership)], 'Membership retrived successfully');
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $membershipFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $membershipFilename = pathinfo($membershipFileNameWithExtention, PATHINFO_FILENAME);
            $membershipExtention = $request->file('image')->getClientOriginalExtension();
            $membershipFileNameToStore = $membershipFilename.'_'.time().'.'.$membershipExtention;
            $membershipPath = $request->file('image')->storeAs('public/Membership', $membershipFileNameToStore);
         }

        $membership = Membership::find($id);
        if(!$membership){
            return $this->sendError('Membership Not Found', ['error'=>'Membership not found']);     
        }

        $user = Auth::user();
         if($user->profile->id !== $membership->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Membership']);
         }

         $membership->organization_name = $request->input('organizationName');
         $membership->membership_id = $request->input('membershipId');
         $membership->membership_type = $request->input('membershipType');
         $membership->membership_payment_date = $request->input('membershipPaymentDate');
         $membership->name = $request->input('name');
         $membership->mobile = $request->input('mobile');
         $membership->email = $request->input('email');
         if($request->hasFile('image')){
            $membership->image = $membershipFileNameToStore;
         }
         $membership->save();
         


         return $this->sendResponse(['Membership' => new MembershipResource($membership)], 'Membership updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $membership = Membership::find($id);
        if(!$membership){
        return $this->sendError('Membership no found', ['error'=>'Membership not found' ]);
    }
    $user = Auth::user();
    if($user->profile->id !== $membership->profile_id){
        return $this->sendError('Unauthorized',['error' =>'You are not allowed to access this Membership' ]);
    }
    Storage::delete('public/Membership/'.$membership->image);
    $membership->delete();

    return $this->sendResponse([], 'Membership deleted successfully');
    }
}