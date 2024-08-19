<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleLoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'profileId' => $this->profile_id,
            'bankName' => $this->bank_name,
            'branch' => $this->branch,
            'loanAccountNo' => $this->loan_account_no,
            'emiDate' => $this->emi_date,
            'startDate' => $this->start_date,
            'duration' =>$this->duration,
            'guarantorName' => $this->guarantor_name,
            'guarantorMobile' =>$this->guarantor_mobile,
            'guarantorEmail' =>$this->guarantor_email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}