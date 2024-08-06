<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetAllocationResource extends JsonResource
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
            'will_id' => $this->will_id,
            'beneficiary_id' => $this->beneficiary_id,
            'level' => $this->level,
            'asset_id' => $this->asset_id,
            'asset_type' => $this->asset_type,
            'allocation' => $this->allocation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
