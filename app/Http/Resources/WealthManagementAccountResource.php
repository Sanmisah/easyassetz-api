<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WealthManagementAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $nominees = BeneficiaryResource::collection($this->nominee);
        $jointHolders = BeneficiaryResource::collection($this->jointHolder);

        return [
            'id' => $this->id,
            'profileId' => $this->profile_id,
            'wealthManagerName' => $this->wealth_manager_name,
            'accountNumber' => $this->account_number,
            'natureOfHolding' => $this->nature_of_holding,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
            'jointHolders' => $jointHolders,
            'nominees'=> $nominees,
            'jointHolders'=> $jointHolders,
        ];
    }
}
