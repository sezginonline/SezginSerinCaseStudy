<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_uuid' => ['required', 'uuid', 'exists:products,uuid'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.discount' => ['required', 'numeric', 'between:0,100'],
        ];
    }
}
