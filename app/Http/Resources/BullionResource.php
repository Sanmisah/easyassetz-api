<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BullionResource extends JsonResource
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
            'metalType' => $this->metal_type,
            'articleDetails' => $this->article_details,
            'weightPerArticle' => $this->weight_per_article,
            'numberOfArticles' => $this->number_of_articles,
            'additionalInformation' =>$this->additional_information,
            'name' => $this->name,
            'mobile' =>$this->mobile,
            'email' =>$this->email,
            'bullionFile' =>$this->image,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at, 
         ];
        }
}