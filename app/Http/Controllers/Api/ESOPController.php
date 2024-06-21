<?php

namespace App\Http\Controllers\Api;

use App\Models\Bond;
use App\Models\ESOP;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ESOPResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class ESOPController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $esop = $user->profile->esop()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['ESOP'=>ESOPResource::collection($esop)],'ESOP retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $esop = new ESOP();
        $esop->profile_id = $user->profile->id;
        $esop->company_name = $request->input('companyName');
        $esop->units_granted = $request->input('units_granted');
        $esop->esops_vested = $request->input('esops_vested');
        $esop->nature_of_holding = $request->input('nature_of_holding');
        $esop->additional_details = $request->input('additional_details');
        $esop->image = $request->input('image');
        $esop->name = $request->input('name');
        $esop->mobile = $request->input('mobile');
        $esop->email = $request->input('email');
        $esop->save();
        
        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $esop->nominee()->attach($nominee_id);
        }

        if($request->has('jointHolders')){
            $joint_holder_id = $request->input('jointHolders');
            $esop->jointHolder()->attach($joint_holder_id);
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
         $esop->load('nominee','jointHolder');
        return $this->sendResponse(['ESOP'=>new ESOPResource($esop)], 'ESOP Details retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
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
         $esop->additional_details = $request->input('additional_details');
         $esop->image = $request->input('image');
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

        if($request->has('jointHolders')) {
            $joint_holder_id = $request->input('jointHolders');
            $esop->jointHolder()->sync($joint_holder_id);
        }else {
            $esop->jointHolder()->detach();
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
        $esop->delete();

        return $this->sendResponse([], 'ESOP Details deleted successfully');
    }


}
