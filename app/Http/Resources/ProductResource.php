<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $uuid
 * @property string $name
 * @property string $code
 * @property float  $price
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code,
            'price' => (float) $this->price,

            'manufacturer' => $this->whenLoaded('manufacturer', function () {
                return [
                    'uuid' => $this->manufacturer->uuid,
                    'name' => $this->manufacturer->name,
                ];
            }),
        ];
    }
}
