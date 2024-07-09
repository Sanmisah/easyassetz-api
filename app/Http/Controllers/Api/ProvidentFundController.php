<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ProvidentFundResource;

class ProvidentFundController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $ProvidentFund = $user->profile->providentFund()->get();
        return $this->sendResponse(['ProvidentFund'=>ProvidentFundResource::collection($ProvidentFund)],'Provident fund details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $pfFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $pfFilename = pathinfo($pfFileNameWithExtention, PATHINFO_FILENAME);
            $pfExtention = $request->file('image')->getClientOriginalExtension();
            $pfFileNameToStore = $pfFilename.'_'.time().'.'.$pfExtention;
            $pfPath = $request->file('image')->storeAs('public/PublicProvidentFund', $ppfFileNameToStore);
         }
         $user = Auth::user();
        $pubilcProvidentFund = new InvestmentFund();
        $pubilcProvidentFund->profile_id = $user->profile->id;
        $pubilcProvidentFund->bank_name = $request->input('bankName');
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
