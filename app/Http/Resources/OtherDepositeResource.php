<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherDepositeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profileId' => $this->profile_id,
            'fdNumber' => $this->fd_number,
            'company' => $this->company,
            'branchName' => $this->branch_name,
            'maturityDate' => $this->maturity_date,
            'maturityAmount' => $this->maturity_amount,
            'holdingType' => $this->holding_type,
            'jointHoldersPan' => $this->joint_holders_pan,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    
    }
}
