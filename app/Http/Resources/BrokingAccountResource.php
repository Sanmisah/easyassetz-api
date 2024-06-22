<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrokingAccountResource extends JsonResource
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
            'brokerName' => $this->broker_name,
            'brokingAccountNumber' => $this->broking_account_number,
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
        ]; 
    
    }
}
