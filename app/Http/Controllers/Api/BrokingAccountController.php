<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BrokingAccount;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BrokingAccountResource;

class BrokingAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $brokingAccount = $user->profile->brokingAccount()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['Bond'=>BrokingAccountResource::collection($brokingAccount)],'Broking account retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('brokingAccountFile')){
            $dematFileNameWithExtention = $request->file('brokingAccountFile')->getClientOriginalName();
            $dematFilename = pathinfo($dematFileNameWithExtention, PATHINFO_FILENAME);
            $dematExtention = $request->file('brokingAccountFile')->getClientOriginalExtension();
            $dematFileNameToStore = $dematFilename.'_'.time().'.'.$dematExtention;
            $dematPath = $request->file('brokingAccountFile')->storeAs('public/brokingAccount', $dematFileNameToStore);
         }

        $user = Auth::user();
        $brokingAccount = new BrokingAccount();
        $brokingAccount->profile_id = $user->profile->id;
        $brokingAccount->broker_name = $request->input('brokerName');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //
    }
}
