<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PersonalLoan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PersonalLoanResource;

class PersonalLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $personalLoan = $user->profile->personalLoan()->get();
        return $this->sendResponse(['PersonalLoan'=>PersonalLoanResource::collection($personalLoan)], "personal Loan retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $personalLoan = new HomeLoan();
        $personalLoan->profile_id = $user->profile->id;
        $personalLoan->bank_name = $request->input('bankName');
        $personalLoan->loan_account_no = $request->input('loanAccountNo');
        $personalLoan->branch = $request->input('branch');
        $formatedDate = $request->input('emiDate');
        $carbonDate = Carbon::parse($formatedDate);
        $iso8601Date = $carbonDate->toIso8601String();
        $personalLoan->emi_date = $iso8601Date;
        $formatedDatestart = $request->input('startDate');
        $carbonDates = Carbon::parse($formatedDatestart);
        $iso8601Dates = $carbonDates->toIso8601String();
        $personalLoan->start_date = $iso8601Dates;
        $personalLoan->duration = $request->input('duration');
        $personalLoan->guarantor_name = $request->input('guarantorName');
        $personalLoan->guarantor_mobile = $request->input('guarantorMobile');
        $personalLoan->guarantor_email = $request->input('guarantorEmail');
        $personalLoan->save();

        return $this->sendResponse(['PersonalLoan'=> new PersonalLoanResource($personalLoan)], 'personal Loan details stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $personalLoan = PersonalLoan::find($id);
        if(!$personalLoan){
            return $this->sendError('Home Loan Not Found',['error'=>'Home Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $personalLoan->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Home Loan']);
         }

        return $this->sendResponse(['PersonalLoan'=>new PersonalLoanResource($personalLoan)], 'Personal Loan retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $personalLoan = PersonalLoan::find($id);
        if(!$personalLoan){
            return $this->sendError('PersonalLoan Not Found', ['error'=>'Personal Loan not found']);
        }

         $user = Auth::user();
         if($user->profile->id !== $PersoanlLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Persoanl Loan']);
         }

         $personalLoan->bank_name = $request->input('bankName');
         $personalLoan->loan_account_no = $request->input('loanAccountNo');
         $personalLoan->branch = $request->input('branch');
         $formatedDate = $request->input('emiDate');
         $carbonDate = Carbon::parse($formatedDate);
         $iso8601Date = $carbonDate->toIso8601String();
         $personalLoan->emi_date = $iso8601Date;
         $formatedDatestart = $request->input('startDate');
         $carbonDates = Carbon::parse($formatedDatestart);
         $iso8601Dates = $carbonDates->toIso8601String();
         $personalLoan->start_date = $iso8601Dates;
         $personalLoan->duration = $request->input('duration');
         $personalLoan->guarantor_name = $request->input('guarantorName');
         $personalLoan->guarantor_mobile = $request->input('guarantorMobile');
         $personalLoan->guarantor_email = $request->input('guarantorEmail');
         $personalLoan->save();
 
         return $this->sendResponse(['PersonalLoan'=> new PersonalLoanResource($personalLoan)], 'personal Loan details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personalLoan = PersonalLoan::find($id);
        if(!$personalLoan){
            return $this->sendError('Persoanl Loan not found', ['error'=>'Personal Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $personalLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Persoanl Loan']);
        }
        $personalLoan->delete();

        return $this->sendResponse([], 'Personal Loan deleted successfully');
    }
}
