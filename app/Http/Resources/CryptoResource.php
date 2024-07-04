<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BeneficiaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CryptoResource extends JsonResource
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
            'cryptoWalletType' => $this->crypto_wallet_type,
            'cryptoWalletAddress' => $this->crypto_wallet_address,
            'holdingType' => $this->holding_type,
            'jointHolderName' => $this->joint_holder_name,
            'jointHolderPan' => $this->joint_holder_pan,
            'exchange' => $this->exchange,
            'tradingAccount' => $this->trading_account,
            'typeOfCurrency' => $this->type_of_currency,
            'holdingQty' => $this->holding_qty,
            'additionalDetails' => $this->additional_details,
            'image' => $this->image,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'nominees'=> $nominees,            
        ];  
    
    }
}
