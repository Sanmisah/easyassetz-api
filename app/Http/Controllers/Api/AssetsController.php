<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GeneralInsuranceResource;
use App\Http\Resources\HealthInsuranceResource;
use App\Http\Resources\OtherInsuranceResource;
use App\Http\Resources\LifeInsuranceResource;
use App\Http\Resources\MotorInsuranceResource;



class AssetsController extends BaseController
{
    //Display a listing of the insurances
    public function list(): JsonResponse
    {
        $list = [];
        $user = Auth::user();

        $motorInsurance = $user->profile->motorInsurance()->select(['id', 'company_name AS name', 'policy_number AS var_1', 'sum_insured AS var_2'])->get()->toArray();
        $list['Insurances']['Motor Insurance'] = $motorInsurance;

        $lifeInsurance = $user->profile->lifeInsurance()->select(['id', 'company_name AS name', 'policy_number AS var_1', 'sum_insured AS var_2'])->get()->toArray();
        $list['Insurances']['Life Insurance'] = $lifeInsurance;
        
        // dd($list);
        $lifeInsurance = $user->profile->lifeInsurance()->with('nominee')->get();
        $otherInsurance = $user->profile->otherInsurance()->with('nominee')->get();
        $healthInsurance = $user->profile->healthInsurance()->with('nominee')->get();
        $generalInsurance = $user->profile->generalInsurance()->with('nominee')->get();
        return $this->sendResponse
        (['list'=> $list],
         "Insurances retrived successfully");
    }
}

"data":  [
    {
        "assetName" : "Other Assets",
        "count" : [
            {
                "type": "Vehical",
                "list": [
                    {
                        "id": 1,
                        "name": "sanjeev"
                    },
                    {
                        
                    }
                ]
            }
        ]
    }
]