<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSavingSchemeResource extends JsonResource
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
            'type' => $this->type,
            'certificateNumber' => $this->certificate_number,
            'maturityDate' => $this->maturity_date,
            'amount' => $this->amount,
            'holdingType' => $this->holding_type,
            'jointHoldersPan' => $this->joint_holders_pan,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    
    }
}
