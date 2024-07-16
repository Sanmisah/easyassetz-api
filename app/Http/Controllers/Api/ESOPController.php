<?php

namespace App\Http\Controllers\Api;

use App\Models\Bond;
use App\Models\ESOP;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ESOPResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;

class ESOPController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $esop = $user->profile->esop()->with('nominee')->get();
        return $this->sendResponse(['ESOP'=>ESOPResource::collection($esop)],'ESOP retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $esopFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $esopFilename = pathinfo($esopFileNameWithExtention, PATHINFO_FILENAME);
            $esopExtention = $request->file('image')->getClientOriginalExtension();
            $esopFileNameToStore = $esopFilename.'_'.time().'.'.$esopExtention;
            $esopPath = $request->file('image')->storeAs('public/ESOP', $esopFileNameToStore);
         }

        $user = Auth::user();
        $esop = new ESOP();
        $esop->profile_id = $user->profile->id;
        $esop->company_name = $request->input('companyName');
        $esop->units_granted = $request->input('units_granted');
        $esop->esops_vested = $request->input('esops_vested');
        $esop->nature_of_holding = $request->input('nature_of_holding');
        $esop->joint_holder_name = $request->input('jointHolderName');
        $esop->joint_holder_pan = $request->input('jointHolderPan');
        $esop->additional_details = $request->input('additional_details');
        if($request->hasFile('image')){
            $esop->image = $esopFileNameToStore;
         }
        $esop->name = $request->input('name');
        $esop->mobile = $request->input('mobile');
        $esop->email = $request->input('email');
        $esop->save();
        
        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $esop->nominee()->attach($nominee_id);
        }

        return $this->sendResponse(['ESOP'=> new ESOPResource($esop)], 'ESOP details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $esop = ESOP::find($id);
        if(!$esop){
            return $this->sendError('ESOP Not Found',['error'=>'ESOP not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $esop->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this ESOP Detail']);
         }
         $esop->load('nominee');
        return $this->sendResponse(['ESOP'=>new ESOPResource($esop)], 'ESOP Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $esopFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $esopFilename = pathinfo($esopFileNameWithExtention, PATHINFO_FILENAME);
            $esopExtention = $request->file('image')->getClientOriginalExtension();
            $esopFileNameToStore = $esopFilename.'_'.time().'.'.$esopExtention;
            $esopPath = $request->file('image')->storeAs('public/ESOP', $esopFileNameToStore);
         }

        $esop = ESOP::find($id);
        if(!$esop){
            return $this->sendError('ESOP Detail Not Found',['error'=>'ESOP Detail not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $esop->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this ESOP Detail']);
         }

         $esop->company_name = $request->input('companyName');
         $esop->units_granted = $request->input('units_granted');
         $esop->esops_vested = $request->input('esops_vested');
         $esop->nature_of_holding = $request->input('nature_of_holding');
         $esop->joint_holder_name = $request->input('jointHolderName');
         $esop->joint_holder_pan = $request->input('jointHolderPan');
         $esop->additional_details = $request->input('additional_details');
         if($request->hasFile('image')){
            $esop->image = $esopFileNameToStore;
         }
         $esop->name = $request->input('name');
         $esop->mobile = $request->input('mobile');
         $esop->email = $request->input('email');
         $esop->save();

         if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $esop->nominee()->sync($nominee_ids);
        }else {
            $esop->nominee()->detach();
        }
 
         return $this->sendResponse(['ESOP'=> new ESOPResource($esop)], 'ESOP details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $esop = ESOP::find($id);
        if(!$esop){
            return $this->sendError('ESOP not found', ['error'=>'ESOP Details not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $esop->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this ESOP Details']);
        }

        if (!empty($esop->image) && Storage::exists('public/ESOP/'.$esop->image)) {
            Storage::delete('public/ESOP/'.$esop->image);
           }

        $esop->delete();

        return $this->sendResponse([], 'ESOP Details deleted successfully');
    }


}
