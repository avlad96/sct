<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'phones' => OrganizationPhoneResource::collection($this->whenLoaded('phones')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
