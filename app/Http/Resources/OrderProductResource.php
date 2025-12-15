<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $uuid
 * @property int    $quantity
 * @property float  $discount
 * @property float  $price
 * @property float  $total_price
 */
class OrderProductResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,

            'product' => new ProductResource(
                $this->whenLoaded('product')
            ),

            'quantity' => $this->quantity,
            'discount' => (float) $this->discount,
            'price' => (float) $this->price,
            'total_price' => (float) $this->total_price,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
