<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'full_legal_name' => $this->full_legal_name,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'nationality' => $this->nationality,
            'country_of_residence' => $this->country_of_residence,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'married_under_special_act' => $this->married_under_special_act,
            'correspondence_email' => $this->correspondence_email,
            'permanent_house_flat_no' => $this->permanent_house_flat_no,
            'permanent_address_line_1' => $this->permanent_address_line_1,
            'permanent_address_line_2' => $this->permanent_address_line_2,
            'permanent_pincode' => $this->permanent_pincode,
            'permanent_city' => $this->permanent_city,
            'permanent_state' => $this->permanent_state,
            'permanent_country' => $this->permanent_country,
            'current_house_flat_no' => $this->current_house_flat_no,
            'current_address_line_1' => $this->current_address_line_1,
            'current_address_line_2' => $this->current_address_line_2,
            'current_pincode' => $this->current_pincode,
            'current_city' => $this->current_city,
            'current_state' => $this->current_state,
            'current_country' => $this->current_country,
            'adhar_number' => $this->adhar_number,
            'adhar_name' => $this->adhar_name,
            'adhar_file' => $this->adhar_file,
            'pan_number' => $this->pan_number,
            'pan_name' => $this->pan_name,
            'pan_file' => $this->pan_file,
            'passport_number' => $this->passport_number,
            'passport_name' => $this->passport_name,
            'passport_expiry_date' => $this->passport_expiry_date,
            'passport_place_of_issue' => $this->passport_place_of_issue,
            'passport_file' => $this->passport_file,
            'driving_licence_number' => $this->driving_licence_number,
            'driving_licence_name' => $this->driving_licence_name,
            'driving_licence_expiry_date' => $this->driving_licence_expiry_date,
            'driving_licence_place_of_issue' => $this->driving_licence_place_of_issue,
            'driving_licence_file' => $this->driving_licence_file,
            'created_at' => $this->created_at->format('d/m/y'),
            'updated_at' => $this->updated_at->format('d/m/y'),
        ];
    }
}
