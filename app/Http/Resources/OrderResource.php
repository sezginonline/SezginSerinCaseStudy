<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $uuid
 * @property string $reference_no
 * @property float  $total_price
 */
class OrderResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'reference_no' => $this->reference_no,

            'user' => $this->whenLoaded('user', function () {
                return [
                    'uuid' => $this->user->uuid,
                    'full_name' => $this->user->full_name,
                    'email' => $this->user->email,
                ];
            }),

            'total_price' => (float) $this->total_price,

            'products' => OrderProductResource::collection(
                $this->whenLoaded('orderProducts')
            ),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
