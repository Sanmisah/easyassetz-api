<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SuperAnnuationResource extends JsonResource
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
            'profileId' => $this->profile_id,
            'companyName' => $this->company_name,
            'masterPolicyNumber' => $this->master_policy_number,
            'empNo' => $this->emp_no,
            'address' => $this->address,
            'annuityAmount' => $this->annuity_amount,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];
    
    }
}
