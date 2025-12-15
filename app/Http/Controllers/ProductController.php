<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ProductSearchRequest $request)
    {
        $search = $request->search;

        $products = Product::with('manufacturer')
            ->where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->get();

        return ProductResource::collection($products);
    }
}
