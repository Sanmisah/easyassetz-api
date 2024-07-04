<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FixDepositeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $nominees = BeneficiaryResource::collection($this->nominee);
        
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'fixDepositeNumber' => $this->fix_deposite_number,
            'bankName' => $this->bank_name,
            'branchNname' => $this->branch_name,
            'maturityDate' => $this->maturity_date,
            'maturityAmmount' => $this->maturity_ammount,
            'holdingType' => $this->holding_type,
            'jointHolderName' => $this->joint_holder_name,
            'jointHolderPan' => $this->joint_holder_pan,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];
    
    }
}
