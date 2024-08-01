<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class WillBusinessController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $propritership = $user->profile->businessAsset()->where('type, propritership')->select(['id', 'company_name AS companyName', 'registration_address AS registrationAddress'])->get();
        $partnershipFirm = $user->profile->businessAsset()->where('type, partnershipFirm')->select(['id', 'company_name AS companyName', 'partnership_deed_file AS partnershipDeedFile'])->get();
        $company = $user->profile->businessAsset()->where('type, company')->select(['id', 'company_name AS companyName', 'registered_address AS registeredAddress'])->get();
        $intellectualProperty = $user->profile->businessAsset()->where('type, intellectualProperty')->select(['id', 'company_name AS companyName', 'registered_address AS registeredAddress'])->get();

       
        return $this->sendResponse(['Propritership'=>$propritership,'PartnershipFirm'=>$partnershipFirm,'Company'=>$company,'IntellectualProperty'=>$intellectualProperty,'OtherAsset'=>$otherAsset], " retrived successfully");
    }
}