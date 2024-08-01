<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class WillBullionController extends BaseController
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $bullion = $user->profile->bullion()->select(['id', 'metal_type AS metalType', 'number_of_articles AS numberOfArticles'])->get();
     

        return $this->sendResponse(['Bullion'=>$bullion], " retrived successfully");
    }
}
