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
            'profileId' => $this->profile_id,
            'type' => $this->type,
            'vehicleType' => $this->vehicle_type,
            'fourWheeler' => $this->four_wheeler,
            'company' => $this->company,
            'model' => $this->model,
            'registrationNumber' => $this->registration_number,
            'yearOfManufacture' => $this->year_of_manufacture,
            'location' => $this->location,
            'hufName' => $this->huf_name,
            'panNumber' => $this->pan_number,
            'hufShare' => $this->huf_share,
            'jewelleryType' => $this->jewellery_type,
            'metal' => $this->metal,
            'preciousStone' => $this->precious_stone,
            'weightPerJewellery' => $this->weight_per_jewellery,
            'quantity' => $this->quantity,
            'typeOfArtifacts' => $this->type_of_artifacts,
            'artistName' => $this->artist_name,
            'paintingName' => $this->painting_name,
            'numberOfArticles' => $this->number_of_articles,
            'digitalAssets' => $this->digital_assets,
            'account' => $this->account,
            'linkedMobileNumber' => $this->linked_mobile_number,
            'description' => $this->description,
            'additionalInformation' => $this->additional_information,
            'jewelleryImages' => $this->jewellery_images,
            'watchImages' => $this->watch_images,
            'artifactImages' => $this->artifact_images,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];  
    
    }
}
