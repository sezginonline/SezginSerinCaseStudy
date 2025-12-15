<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $order = Order::create([
                'user_id' => auth()->id(),
            ]);

            foreach ($request->products as $item) {
                $product = Product::whereUuid($item['product_uuid'])->firstOrFail();

                OrderProduct::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'discount'   => $item['discount'],
                    'price'      => $product->price,
                    // total_price OrderProduct modelinde otomatik hesaplanıyor
                ]);
            }

            // order.total_price = order_products.total_price SUM
            $order->recalculateTotalPrice();

            return new OrderResource(
                $order->load([
                    'user',
                    'orderProducts.product.manufacturer',
                ])
            );
        });
    }
}
