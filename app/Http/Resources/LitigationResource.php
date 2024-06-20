<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LitigationResource extends JsonResource
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
            'litigationType' => $this->litigation_type,
            'courtName' => $this->court_name,
            'city' => $this->city,
            'caseRegistrationNumber' => $this->case_registration_number,
            'myStatus' => $this->my_status,
            'otherPartyName' => $this->other_party_name,
            'otherPartyAddress' => $this->other_party_address,
            'lawyerName' => $this->lawyer_name,
            'lawyerContact' => $this->lawyer_contact,
            'caseFillingDate' => $this->case_filling_date,
            'status' => $this->status,
            'image' => $this->image,
            'additionalInformation' => $this->additional_information,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ]; 
    
    }
}
