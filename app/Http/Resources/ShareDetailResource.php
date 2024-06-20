<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShareDetailResource extends JsonResource
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
            'companyName' => $this->company_name,
            'certificateNumber' => $this->certificate_number,
            'noOfShares' => $this->no_of_shares,
            'distinguishNoFrom' => $this->distinguish_no_from,
            'distinguishNoTo' => $this->distinguish_no_to,
            'faceValue' => $this->face_value,
            'natureOfHolding' => $this->nature_of_holding,
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
