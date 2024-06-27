<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'profile_id' => $this->profile_id,
            'bankName' => $this->bank_name,
            'accountType' => $this->account_type,
            'accountNumber' => $this->account_number,
            'branchName' => $this->branch_name,
            'city' => $this->city,
            'holdingType' => $this->holding_type,
            'jointHoldersPan' => $this->joint_holders_pan,
            'image' => $this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    
    }
}
