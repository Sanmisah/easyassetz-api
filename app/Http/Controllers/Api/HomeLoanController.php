<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\HomeLoan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HomeLoanResource;
use App\Http\Controllers\Api\BaseController;

class HomeLoanController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $homeLoan = $user->profile->homeLoan()->get();
        return $this->sendResponse(['HomeLoan'=>HomeLoanResource::collection($homeLoan)], "Home Loan retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $homeLoan = new HomeLoan();
        $homeLoan->profile_id = $user->profile->id;
        $homeLoan->bank_name = $request->input('bankName');
        $homeLoan->loan_account_no = $request->input('loanAccountNo');
        $homeLoan->branch = $request->input('branch');
        $formatedDate = $request->input('emiDate');
        $carbonDate = Carbon::parse($formatedDate);
        $iso8601Date = $carbonDate->toIso8601String();
        $homeLoan->emi_date = $iso8601Date;
        $formatedDatestart = $request->input('startDate');
        $carbonDates = Carbon::parse($formatedDatestart);
        $iso8601Dates = $carbonDates->toIso8601String();
        $homeLoan->start_date = $iso8601Dates;
        $homeLoan->duration = $request->input('duration');
        $homeLoan->guarantor_name = $request->input('guarantorName');
        $homeLoan->guarantor_mobile = $request->input('guarantorMobile');
        $homeLoan->guarantor_email = $request->input('guarantorEmail');
        $homeLoan->save();

        return $this->sendResponse(['HomeLoan'=> new HomeLoanResource($homeLoan)], 'Home Loan details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $homeLoan = HomeLoan::find($id);
        if(!$homeLoan){
            return $this->sendError('Home Loan Not Found',['error'=>'Home Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $homeLoan->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Home Loan']);
         }

        return $this->sendResponse(['HomeLoan'=>new HomeLoanResource($homeLoan)], 'Home Loan retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $homeLoan = HomeLoan::find($id);
        if(!$homeLoan){
            return $this->sendError('HomeLoan Not Found', ['error'=>'Home Loan not found']);
        }

         $user = Auth::user();
         if($user->profile->id !== $homeLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Home Loan']);
         }
         $homeLoan->bank_name = $request->input('bankName');
         $homeLoan->loan_account_no = $request->input('loanAccountNo');
         $homeLoan->branch = $request->input('branch');
         $homeLoan->emi_date = $request->input('emiDate');
         $homeLoan->start_date = $request->input('startDate');
         $homeLoan->duration = $request->input('duration');
         $homeLoan->guarantor_name = $request->input('guarantorName');
         $homeLoan->guarantor_mobile = $request->input('guarantorMobile');
         $homeLoan->guarantor_email = $request->input('guarantorEmail');
         $homeLoan->save();

         return $this->sendResponse(['HomeLoan'=> new HomeLoanResource($homeLoan)], 'Home Loan details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $homeLoan = HomeLoan::find($id);
        if(!$homeLoan){
            return $this->sendError('Home Loan not found', ['error'=>'Home Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $homeLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Home Loan']);
        }
        $homeLoan->delete();

        return $this->sendResponse([], 'Home Loan deleted successfully');
    }
}
