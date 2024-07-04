<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAssetsResource extends JsonResource
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
            'type' => $this->type,
            'firmName' => $this->firm_name,
            'registeredAddress' => $this->registered_address,
            'firmsRegistrationNumberType' => $this->firm_no_type,
            'firmsRegistrationNumber' => $this->firms_registration_number,
            'holdingPercentage' => $this->holding_percentage,
            'companyName' => $this->company_name,
            'companyAddress' => $this->company_address,
            'myStatus' => $this->my_status,
            'typeOfInvestment' => $this->type_of_investment,
            'holdingType' => $this->holding_type,
            'jointHolderName' => $this->joint_holder_name,
            'jointHolderPan' => $this->joint_holder_pan,
            'documentAvailability' => $this->document_availability,
            'shareCentificateFile' => $this->share_centificate_file,
            'partnershipDeedFile' => $this->partnership_deed_file,
            'jvAgreementFile' => $this->jv_agreement_file,
            'loanDepositeReceipt' => $this->loan_deposite_receipt,
            'promisoryNote' => $this->promisory_note,
            'typeOfIp' => $this->type_of_ip,
            'expiryDate' => $this->expiry_date,
            'whetherAssigned' => $this->whether_assigned,
            'nameOfAssignee' => $this->name_of_assignee,
            'dateOfAssignment' => $this->date_of_assignment,
            'additionalInformation' => $this->additional_information,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
        ];
    
    }
}
