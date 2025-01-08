<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeSpaceResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'slug' => $this->slug,
            'duration' => $this->duration,
            'price' => $this->price,
            'thumbnail' => $this->thumbnail,
            'about' => $this->about,
            'city' => new CityResource($this->whenLoaded('city')), // new hanya mengambil sebuah/satu object saja
            'photos' => OfficeSpacePhotoResource::collection($this->whenLoaded('photos')), // collection mengambil lebih dari 1
            'benefits' => OfficeSpaceBenefitResource::collection($this->whenLoaded('benefits')),
        ];
    }
}
