<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicProvidentFundResource extends JsonResource
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
            'bank_name' => $this->bank_name,
            'ppf_account_no' => $this->ppf_account_no,
            'branch' => $this->branch,
            'nature_of_holding' => $this->nature_of_holding,
            'joint_holder_name' => $this->joint_holder_name,
            'joint_holder_pan' => $this->joint_holder_pan,
            'additional_details' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'nominees' => $nominees,
        ];
    
    }
}
