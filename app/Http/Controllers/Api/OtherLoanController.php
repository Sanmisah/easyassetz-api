<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\OtherLoan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OtherLoanResource;
use App\Http\Controllers\Api\BaseController;

class OtherLoanController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $otherLoan = $user->profile->otherLoan()->get();
        return $this->sendResponse(['OtherLoan'=>OtherLoanResource::collection($otherLoan)], "Other Loan retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $otherLoan = new OtherLoan();
        $otherLoan->profile_id = $user->profile->id;
        $otherLoan->bank_name = $request->input('bankName');
        $otherLoan->loan_account_no = $request->input('loanAccountNo');
        $otherLoan->branch = $request->input('branch');
        $otherLoan->emi_date = $request->input('emiDate');
        $otherLoan->start_date = $request->input('startDate');
        $otherLoan->duration = $request->input('duration');
        $otherLoan->guarantor_name = $request->input('guarantorName');
        $otherLoan->guarantor_mobile = $request->input('guarantorMobile');
        $otherLoan->guarantor_email = $request->input('guarantorEmail');
        $otherLoan->save();

        return $this->sendResponse(['OtherLoan'=> new OtherLoanResource($otherLoan)], 'Other Loan details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $otherLoan = OtherLoan::find($id);
        if(!$otherLoan){
            return $this->sendError('Other Loan Not Found',['error'=>'Other Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherLoan->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this Other Loan']);
         }

        return $this->sendResponse(['OtherLoan'=>new OtherLoanResource($otherLoan)], 'Other Loan retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $otherLoan = OtherLoan::find($id);
        if(!$otherLoan){
            return $this->sendError('Other Loan Not Found', ['error'=>'Other Loan not found']);
        }

         $user = Auth::user();
         if($user->profile->id !== $otherLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Other Loan']);
         }
       
         $otherLoan->bank_name = $request->input('bankName');
         $otherLoan->loan_account_no = $request->input('loanAccountNo');
         $otherLoan->branch = $request->input('branch');
         $otherLoan->emi_date = $request->input('emiDate');
         $otherLoan->start_date = $request->input('startDate');
         $otherLoan->duration = $request->input('duration');
         $otherLoan->guarantor_name = $request->input('guarantorName');
         $otherLoan->guarantor_mobile = $request->input('guarantorMobile');
         $otherLoan->guarantor_email = $request->input('guarantorEmail');
         $otherLoan->save();
 
         return $this->sendResponse(['OtherLoan'=> new OtherLoanResource($otherLoan)], 'Other Loan details Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $otherLoan = OtherLoan::find($id);
        if(!$otherLoan){
            return $this->sendError('Other Loan not found', ['error'=>'Other Loan not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $otherLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this Other Loan']);
        }
        $otherLoan->delete();

        return $this->sendResponse([], 'Other Loan deleted successfully');
    }
}
