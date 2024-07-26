<?php

namespace App\Http\Controllers\Api;

use App\Models\VehicleLoan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VehicleLoanResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\VehicleLoanController;

class VehicleLoanController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $vehicleLoan = $user->profile->vehicleLoan()->get();
        return $this->sendResponse(['VehicleLoan'=>VehicleLoanResource::collection($vehicleLoan)], "Vehicle Loan retrived successfully");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
     $vehicleLoan = new VehicleLoan();
     $vehicleLoan->profile_id = $user->profile->id;
     $vehicleLoan->bank_name = $request->input('bankName');  
     $vehicleLoan->loan_account_no = $request->input('loanAccountNo');
     $vehicleLoan->emi_date = $request->input('emiDate');
     $vehicleLoan->start_date = $request->input('startDate');
     $vehicleLoan->duration = $request->input('duration');
     $vehicleLoan->guarantor_name = $request->input('guarantorName');
     $vehicleLoan->guarantor_mobile = $request->input('guarantorMobile');
     $vehicleLoan->guarantor_email = $request->input('guarantorEmail');
     $vehicleLoan->save();

     return $this->sendResponse(['VehicleLoan'=> new VehicleLoanResource($vehicleLoan)], 'Vehicle Loan details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $vehicleLoan = VehicleLoan::find($id);
        if(!$vehicleLoan){
            return$this->sendError('Vehicle Loan Not Found' , ['error' => 'Vehicle Loan not found']); 
        }
        $user = Auth::user();
        if($user->profile->id !== $vehicleLoan->profile_id){
            return $this->sendError('Unauthorized', ['error' => 'You are Not Allowed to view this Vehicle Loan']);
        }
        
        return $this->sendResponse(['VehicleLoan' => new VehicleLoanResource($vehicleLoan)], 'Vehicle Loan retrived successfully');
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $vehicleLoan = VehicleLoan::find($id);
        if(!$vehicleLoan){
            return $this->sendError('VehicleLoan Not Found', ['error'=>'Vehicle Loan not found']);     
        }

        $user = Auth::user();
         if($user->profile->id !== $vehicleLoan->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to update this Vehicle Loan']);
         }

         $vehicleLoan->bank_name = $request->input('bankName');
         $vehicleLoan->loan_account_no = $request->input('loanAccountNo');
         $vehicleLoan->emi_date = $request->input('emiDate');
         $vehicleLoan->start_date = $request->input('startDate');
         $vehicleLoan->duration = $request->input('duration');
         $vehicleLoan->guarantor_name = $request->input('guarantorName');
         $vehicleLoan->guarantor_mobile = $request->input('guarantorMobile');
         $vehicleLoan->guarantor_email = $request->input('guarantorEmail');
         $vehicleLoan->save();
         


         return $this->sendResponse(['VehicleLoan' => new VehicleLoanResource($vehicleLoan)], 'Vehicle Loan updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $vehicleLoan = VehicleLoan::find($id);
        if(!$vehicleLoan){
        return $this->sendError('Vehicle Loan no found', ['error'=>'Vehicle Loan not found' ]);
    }
    $user = Auth::user();
    if($user->profile->id !== $vehicleLoan->profile_id){
        return $this->sendError('Unauthorized',['error' =>'You are not allowed to access this Vehicle Loan' ]);
    }
    $vehicleLoan->delete();

    return $this->sendResponse([], 'VehicleLoan deleted successfully');

    }
}