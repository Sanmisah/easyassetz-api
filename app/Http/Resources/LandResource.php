<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandResource extends JsonResource
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
            'propertyType' => $this->property_type,
            'surveyNumber' => $this->survey_number,
            'address' => $this->address,
            'villageName' => $this->village_name,
            'district' => $this->district,
            'taluka' => $this->taluka,
            'ownershipByVirtueOf' => $this->ownership_by_virtue_of,
            'ownershipType' => $this->ownership_type,
            'firstHoldersName' => $this->first_holders_name,
            'firstHoldersRelation' => $this->first_holders_relation,
            'firstHoldersPan' => $this->first_holders_pan,
            'firstHoldersAadhar' => $this->first_holders_aadhar,
            'jointHoldersName' => $this->joint_holders_name,
            'jointHoldersRelation' => $this->joint_holders_relation,
            'jointHoldersPan' => $this->joint_holders_pan,
            'jointHoldersAadhar' => $this->joint_holders_aadhar,
            'anyLoanLitigation' => $this->any_loan_litigation,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    
    }
}