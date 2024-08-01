<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource;
use App\Http\Controllers\Api\BaseController;

class WillInsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $motorInsurance = $user->profile->motorInsurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get();
        $healthInsurance = $user->profile->healthInsurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get();
        $lifeInsurance = $user->profile->lifeInsurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get();
        $generalInsurance = $user->profile->generalInsurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get();
        $otherInsurance = $user->profile->otherInsurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get();

        // $motorInsurance = $user->profile->insurance()->select(['id', 'company_name', 'policy_number ', 'premium'])->get()->toArray();
        // $healthInsurance = $user->profile->insurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get()->toArray();
        // $lifeInsurance = $user->profile->insurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get()->toArray();
        // $generalInsurance = $user->profile->insurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get()->toArray();
        // $otherInsurance = $user->profile->insurance()->select(['id', 'company_name', 'policy_number', 'premium'])->get()->toArray();


        return $this->sendResponse(['MotorInsurance'=>$motorInsurance,'HealthInsurance'=>$healthInsurance,'LifeInsurance'=>$lifeInsurance,'GeneralInsurance'=>$generalInsurance,'OtherInsurance'=>$otherInsurance], " retrived successfully");
    }
}