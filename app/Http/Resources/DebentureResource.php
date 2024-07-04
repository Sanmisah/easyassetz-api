<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DebentureResource extends JsonResource
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
            'bankServiceProvider' => $this->bank_service_provider,
            'companyName' => $this->company_name,
            'folioNumber' => $this->folio_number,
            'numberOfDebentures' => $this->number_of_debentures,
            'certificateNumber' => $this->certificate_number,
            'distinguishNoFrom' => $this->distinguish_no_from,
            'distinguishNoTo' => $this->distinguish_no_to,
            'faceValue' => $this->face_value,
            'natureOfHolding' => $this->nature_of_holding,
            'jointHolderName' => $this->joint_holder_name,
            'jointHolderPan' => $this->joint_holder_pan,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];   
    
    }
}
