<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'profile_id' => $this->profile_id,
            'full_legal_name' => $this->full_legal_name,
            'relationship' => $this->relationship,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'guardian_full_legal_name' => $this->guardian_full_legal_name,
            'guardian_mobile_number' => $this->guardian_mobile_number,
            'guardian_email' => $this->guardian_email,
            'guardian_city' => $this->guardian_city,
            'guardian_state' => $this->guardian_state,
            'adhar_number' => $this->adhar_number,
            'pan_number' => $this->pan_number,
            'passport_number' => $this->passport_number,
            'driving_licence_number' => $this->driving_licence_number,
            'religion' => $this->religion,
            'nationality' => $this->nationality,
            'house_flat_no' => $this->house_flat_no,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'pincode' => $this->pincode,
            'beneficiary_city' => $this->beneficiary_city,
            'beneficiary_state' => $this->beneficiary_state,
            'beneficiary_country' => $this->beneficiary_country,
            'charity_name' => $this->charity_name,
            'charity_address_1' => $this->charity_address_1,
            'charity_address_2' => $this->charity_address_2,
            'charity_city' => $this->charity_city,
            'charity_state' => $this->charity_state,
            'charity_phone_number' => $this->charity_phone_number,
            'charity_email' => $this->charity_email,
            'charity_contact_person' => $this->charity_contact_person,
            'charity_website' => $this->charity_website,
            'charity_specific_instruction' => $this->charity_specific_instruction,
            'created_at' => $this->created_at->format('d/m/y'),
            'updated_at' => $this->updated_at->format('d/m/y'),
        ];
    }
}
