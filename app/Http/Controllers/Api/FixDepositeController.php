<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FixDepositeResource;
use App\Http\Controllers\Api\BaseController;

class FixDepositeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $fixDeposite = $user->profile->fixDeposite()->with('nominee','jointHolder')->get();
        return $this->sendResponse(['FixDeposite'=>FixDepositeResource::collection($fixDeposite)],'Fix deposite details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->hasFile('image')){
            $fdFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $fdFilename = pathinfo($fdFileNameWithExtention, PATHINFO_FILENAME);
            $fdExtention = $request->file('image')->getClientOriginalExtension();
            $fdFileNameToStore = $fdFilename.'_'.time().'.'.$fdExtention;
            $fdPath = $request->file('image')->storeAs('public/FixDeposite', $fdFileNameToStore);
         }

        $user = Auth::user();
        $fixDeposite = new InvestmentFund();
        $fixDeposite->profile_id = $user->profile->id;
        $fixDeposit->fix_deposite_number = $request->input('fix_deposite_number');
        $fixDeposit->bank_name = $request->input('bank_name');
        $fixDeposit->branch_name = $request->input('branch_name');
        $fixDeposit->maturity_date = $request->input('maturity_date');
        $fixDeposit->maturity_ammount = $request->input('maturity_ammount');
        $fixDeposit->holding_type = $request->input('holding_type');
        $fixDeposit->joint_holders_pan = $request->input('joint_holders_pan');
        $fixDeposit->additional_details = $request->input('additional_details');
        $fixDeposit->image = $request->input('image');
        $fixDeposit->save();    }

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
