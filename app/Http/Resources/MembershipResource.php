<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MembershipResource;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    // /**
    //  * Transform the resource into an array.
    //  *
    //  * @return array<string, mixed>
    //  */
    public function toArray(Request $request): array
    {
        
        $nominees = BeneficiaryResource::collection($this->nominee);
    
        return [
            'id' => $this->id,
            'profileId' => $this->profile_id,
            'organizationName' => $this->organization_name,
            'membershipId' => $this->membership_id,
            'membershipType' => $this->membership_type,
            'membershipPaymentDate' => $this->membership_payment_date,
            'name' => $this->name,
            'mobile' =>$this->mobile,
            'email' =>$this->email,
            'image' =>$this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees' => $nominees,
         ];
    }
}