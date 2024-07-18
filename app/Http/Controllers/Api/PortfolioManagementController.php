<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\InvestmentFund;
use Illuminate\Http\JsonResponse;
use App\Models\PortfolioManagement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\PortfolioManagementResource;
use App\Http\Requests\StorePortfolioManagementRequest;
use App\Http\Requests\UpdatePortfolioManagementRequest;

class PortfolioManagementController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $portfolioManagement = $user->profile->portfolioManagement()->with('nominee')->get();
        return $this->sendResponse(['PortfolioManagement'=>PortfolioManagementResource::collection($portfolioManagement)],'portfolio management service details retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortfolioManagementRequest $request): JsonResponse
    {
        if($request->hasFile('image')){
            $portfolioFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $portfolioFilename = pathinfo($portfolioFileNameWithExtention, PATHINFO_FILENAME);
            $portfolioExtention = $request->file('image')->getClientOriginalExtension();
            $portfolioFileNameToStore = $portfolioFilename.'_'.time().'.'.$portfolioExtention;
            $portfolioPath = $request->file('image')->storeAs('public/PortfolioManagement', $portfolioFileNameToStore);
         }

        $user = Auth::user();
        $portfolioManagement = new PortfolioManagement();
        $portfolioManagement->profile_id = $user->profile->id;
        $portfolioManagement->fund_name = $request->input('fundName');
        $portfolioManagement->folio_number = $request->input('folioNumber');
        $portfolioManagement->nature_of_holding = $request->input('natureOfHolding');
        $portfolioManagement->joint_holder_name = $request->input('jointHolderName');
        $portfolioManagement->joint_holder_pan = $request->input('jointHolderPan');
        $portfolioManagement->additional_details = $request->input('additionalDetails');
        if($request->hasFile('image')){
            $portfolioManagement->image = $portfolioFileNameToStore;
         } 
        $portfolioManagement->name = $request->input('name');
        $portfolioManagement->mobile = $request->input('mobile');
        $portfolioManagement->email = $request->input('email');
        $portfolioManagement->save();

        if($request->has('nominees')){
            $nominee_id = $request->input('nominees');
            $portfolioManagement->nominee()->attach($nominee_id);
        }


        return $this->sendResponse(['PortfolioManagement'=> new PortfolioManagementResource($portfolioManagement)], 'portfolio management service details stored successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $portfolioManagement = PortfolioManagement::find($id);
        if(!$portfolioManagement){
            return $this->sendError('portfolio management service Not Found',['error'=>'portfolio management service not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $portfolioManagement->profile_id){
           return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this portfolio management service']);
         }
         $portfolioManagement->load('nominee');
        return $this->sendResponse(['PortfolioManagement'=>new PortfolioManagementResource($portfolioManagement)], 'portfolio management service retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePortfolioManagementRequest $request, string $id): JsonResponse
    {
        if($request->hasFile('image')){
            $portfolioFileNameWithExtention = $request->file('image')->getClientOriginalName();
            $portfolioFilename = pathinfo($portfolioFileNameWithExtention, PATHINFO_FILENAME);
            $portfolioExtention = $request->file('image')->getClientOriginalExtension();
            $portfolioFileNameToStore = $portfolioFilename.'_'.time().'.'.$portfolioExtention;
            $portfolioPath = $request->file('image')->storeAs('public/PortfolioManagement', $portfolioFileNameToStore);
         }

         $portfolioManagement = PortfolioManagement::find($id);
         if(!$portfolioManagement){
             return $this->sendError('portfolio management service Not Found',['error'=>'portfolio management service not found']);
         }
         $user = Auth::user();
         if($user->profile->id !== $portfolioManagement->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to view this portfolio management service']);
          }

          $portfolioManagement->fund_name = $request->input('fundName');
          $portfolioManagement->folio_number = $request->input('folioNumber');
          $portfolioManagement->nature_of_holding = $request->input('natureOfHolding');
          $portfolioManagement->joint_holder_name = $request->input('jointHolderName');
          $portfolioManagement->joint_holder_pan = $request->input('jointHolderPan');
          $portfolioManagement->additional_details = $request->input('additionalDetails');
          if($request->hasFile('image')){
              $portfolioManagement->image = $portfolioFileNameToStore;
           } 
          $portfolioManagement->name = $request->input('name');
          $portfolioManagement->mobile = $request->input('mobile');
          $portfolioManagement->email = $request->input('email');
          $portfolioManagement->save();

          if($request->has('nominees')) {
            $nominee_ids = $request->input('nominees');
            $portfolioManagement->nominee()->sync($nominee_ids);
        }else {
            $portfolioManagement->nominee()->detach();
        }
         return $this->sendResponse(['PortfolioManagement'=> new PortfolioManagementResource($portfolioManagement)], 'portfolio management service details updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $portfolioManagement = PortfolioManagement::find($id);
        if(!$portfolioManagement){
            return $this->sendError('Portfolio management service not found', ['error'=>'portfolio management service not found']);
        }
        $user = Auth::user();
        if($user->profile->id !== $portfolioManagement->profile_id){
            return $this->sendError('Unauthorized', ['error'=>'You are not allowed to access this portfolio management service']);
        }

        if (!empty($portfolioManagement->image) && Storage::exists('public/PortfolioManagement/'.$portfolioManagement->image)) {
            Storage::delete('public/PortfolioManagement/'.$portfolioManagement->image);
           }

        $portfolioManagement->delete();

        return $this->sendResponse([], 'portfolio management service deleted successfully');
    }
}
