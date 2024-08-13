<?php

namespace App\Http\Controllers\Api;

use App\Models\Will;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Models\AssetAllocation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\AssetAllocationResource;

class AssetAllocationController extends BaseController
{
    public function storeMultipleAssets(Request $request): JsonResponse
    {
        $data = $request->json()->all();

      // $data = [
      //       ['beneficiary_id' => 1, 'level' => 'Secondary', 'asset_id' => 123, 'asset_type' => 'new Stock', 'allocation' => 50.00],
      //       ['beneficiary_id' =>2, 'level' => 'Secondary', 'asset_id' => 12, 'asset_type' => 'ABC', 'allocation' => 99.00],
      // ];
     
        $profile_id = auth()->user()->profile->id;
         $will = Will::firstOrCreate(['profile_id' => $profile_id]);

            // $assets = $data['assets'];   
            // $firstRecord = !empty($data) ? $assets[0] : null;

            foreach($data as $dta){
                    $assetId = $dta['asset_id'] ?? null;
                    $assetType = $dta['asset_type'] ?? null;
                    $level = $dta['level'] ?? null;
                
                $assetAllocation = AssetAllocation::where('will_id', $will->id)->where('asset_id', $assetId)->where('asset_type', $assetType)->where('level', $level)->get();
                 foreach($assetAllocation as $delete){
                    $delete->delete(); 
                 }
             }

                $assets = $data; 
                foreach ($assets as &$asset) {
                    $asset['will_id'] = $will->id; 
                }

                 AssetAllocation::insert($assets);
        
        
        //     $will = new Will();
        //     $will->profile_id = $profile_id;
        //     $will->save();
        //     $assets = $data; 
        //     foreach ($assets as &$asset) {
        //         $asset['will_id'] = $will->id; 
        //     }
        //    AssetAllocation::insert($assets);
    
    
  $assetAllocation = AssetAllocation::where('will_id', $will->id)->get();
 return $this->sendResponse(['Assets'=>AssetAllocationResource::collection($assetAllocation)], 'assets distributed succesfully');
 
}




  public function getMultipleRecords(string $asset_id, string $asset_type, string $level): JsonResponse
  {

    $user = Auth::user();
    $data = $user->profile->will->assetAllocation()
    ->where('asset_id', $asset_id)
    ->where('asset_type', $asset_type) 
    ->where('level', $level)->get();
    // return response()->json(['Data'=>$data]);
    return $this->sendResponse(['Assets' =>AssetAllocationResource::collection($data)], 'assets retrived successfully');
  }





//   public function getPrimaryBeneficiaries(string $asset_id, string $asset_type, string $level): JsonResponse
//   {
    
//      $user = Auth::user();
//      $data = $user->profile->will->assetAllocation()
//      ->where('level', 'Primary')
//      ->where('asset_id', $asset_id)
//      ->where('asset_type', $asset_type)
//      ->pluck('beneficiary_id');
     
//      $beneficiary = Beneficiary::whereIn('id', $data)->select('full_legal_name')->get();

//      $allocation = $user->profile->will->assetAllocation()
//      ->where('level', 'Primary')
//      ->where('asset_id', $asset_id)
//      ->where('asset_type', $asset_type)
//      ->WhereIn('beneficiary_id', $data)
//      ->select('allocation')->get();
     
//      $count = $user->profile->will->assetAllocation()
//      ->where('level', 'Primary')
//      ->where('asset_id', $asset_id)
//      ->where('asset_type', $asset_type)
//      ->count();

//      return $this->sendResponse(['Beneficiaries'=> $beneficiary, 'Allocation'=> $allocation, 'Count'=>$count], 'primary beneficiaries retrived successfully');
     
//     //  return $this->sendResponse(['Assets' =>AssetAllocationResource::collection($data), 'Count'=>$count], 'primary beneficiaries retrived successfully');
 
//  }


  
}




















// $profile_id = auth()->user()->profile->id;

    // $will = Will::where('profile_id', $profile_id)->first();

    // if (!$will) {
    //     $will = new Will();
    //     $will->profile_id = $profile_id;
    //     $will->save();
    // }

    // // $assets = $request->json('assets');
    // $assets = [
    //     [ 'id' => '',
    //      'beneficiary_id' => 1,
    //      'level' => 'Primary',
    //      'asset_id' => 123,
    //      'asset_type' => 'Stock',
    //      'allocation' => 50.00
    //     ],
    //     [
    //      'beneficiary_id' => 2,
    //      'level' => 'Secondary',
    //      'asset_id' => 456,
    //      'asset_type' => 'Bond',
    //      'allocation' => 25.00
    //      ],
    // ];  
    // foreach ($assets as &$asset) {
    //     $asset['will_id'] = $will->id;
    // }

    // AssetAllocation::upsert(
    //     $assets, 
    //     ['will_id', 'beneficiary_id', 'asset_id', 'asset_type', 'level'], 
    //     ['id']
    // );  









// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use App\Models\AssetAllocation;
// use App\Models\Will;

// public function storeMultipleAssets(Request $request): JsonResponse
// {
//     // Step 1: Validate incoming data
//     $validator = Validator::make($request->json()->all(), [
//         'assets.*.beneficiary_id' => 'required|exists:beneficiaries,id',
//         'assets.*.will_id' => 'required|exists:wills,id',
//         'assets.*.level' => 'nullable|in:Primary,Secondary,Tertiary',
//         'assets.*.asset_id' => 'nullable|integer',
//         'assets.*.asset_type' => 'nullable|string',
//         'assets.*.allocation' => 'nullable|numeric',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     // Step 2: Create or find the Will
//     $will = new Will();
//     $will->profile_id = auth()->user()->profile->id;
//     $will->save();

//     // Step 3: Prepare and process data
//     $assets = $request->json('assets');
    
//     foreach ($assets as $asset) {
//         // Check if the asset already exists
//         $existingAsset = AssetAllocation::find($asset['id']); // Assuming 'id' is provided in each asset
        
//         if ($existingAsset) {
//             // Update existing record
//             $existingAsset->update([
//                 'beneficiary_id' => $asset['beneficiary_id'],
//                 'will_id' => $will->id,
//                 'level' => $asset['level'],
//                 'asset_id' => $asset['asset_id'],
//                 'asset_type' => $asset['asset_type'],
//                 'allocation' => $asset['allocation'],
//             ]);
//         } else {
//             // Create a new record
//             AssetAllocation::create([
//                 'beneficiary_id' => $asset['beneficiary_id'],
//                 'will_id' => $will->id,
//                 'level' => $asset['level'],
//                 'asset_id' => $asset['asset_id'],
//                 'asset_type' => $asset['asset_type'],
//                 'allocation' => $asset['allocation'],
//             ]);
//         }
//     }

//     // Step 4: Return a success response
//     return response()->json(['message' => 'Assets stored or updated successfully.'], 201);
// }