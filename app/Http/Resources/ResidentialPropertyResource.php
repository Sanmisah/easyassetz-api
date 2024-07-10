<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidentialPropertyResource extends JsonResource
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
            'propertyType' => $this->property_type,
            'houseNumber' => $this->house_number,
            'address1' => $this->address_1,
            'pincode' => $this->pincode,
            'area' => $this->area,
            'city' => $this->city,
            'state' => $this->state,
            'propertyStatus' => $this->property_status,
            'ownershipByVirtueOf' => $this->ownership_by_virtue_of,
            'ownershipType' => $this->ownership_type,
            'firstHoldersName' => $this->first_holders_name,
            'firstHoldersRelation' => $this->first_holders_relation,
            'firstHoldersAadhar' => $this->first_holders_aadhar,
            'firstHoldersPan' => $this->first_holders_pan,
            'jointHoldersName' => $this->joint_holders_name,
            'jointHoldersRelation' => $this->joint_holders_relation,
            'jointHoldersPan' => $this->joint_holders_pan,
            'anyLoanLitigation' => $this->any_loan_litigation,
            'litigationFile' => $this->litigationFile,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];
    
    }
}
