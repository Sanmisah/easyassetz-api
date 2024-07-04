<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BankLockerResource extends JsonResource
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
            'bankName' => $this->bank_name,
            'branch' => $this->branch,
            'lockerNumber' => $this->locker_number,
            'natureOfHolding' => $this->nature_of_holding,
            'jointHolderName' => $this->joint_holder_name,
            'jointHolderPan' => $this->joint_holder_pan,
            'rentDueDate' => $this->rent_due_date,
            'annualRent' => $this->annual_rent,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];
        
    }
}
