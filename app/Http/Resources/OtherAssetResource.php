<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherAssetResource extends JsonResource
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
            'profile_id' => $this->profile_id,
            'type' => $this->type,
            'vehicle_type' => $this->vehicle_type,
            'four_wheeler' => $this->four_wheeler,
            'company' => $this->company,
            'model' => $this->model,
            'registration_number' => $this->registration_number,
            'year_of_manufacture' => $this->year_of_manufacture,
            'location' => $this->location,
            'huf_name' => $this->huf_name,
            'pan_number' => $this->pan_number,
            'huf_share' => $this->huf_share,
            'jewellery_type' => $this->jewellery_type,
            'metal' => $this->metal,
            'precious_stone' => $this->precious_stone,
            'weight_per_jewellery' => $this->weight_per_jewellery,
            'quantity' => $this->quantity,
            'type_of_artifacts' => $this->type_of_artifacts,
            'artist_name' => $this->artist_name,
            'painting_name' => $this->painting_name,
            'number_of_articles' => $this->number_of_articles,
            'digital_assets' => $this->digital_assets,
            'account' => $this->account,
            'linked_mobile_number' => $this->linked_mobile_number,
            'description' => $this->description,
            'additional_information' => $this->additional_information,
            'jewellery_images' => $this->jewellery_images,
            'watch_images' => $this->watch_images,
            'artifact_images' => $this->artifact_images,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];  
    
    }
}
