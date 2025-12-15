<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OrderProduct extends Model
{
    use SoftDeletes;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'discount',
        'price',
        'total_price',
    ];

    protected $casts = [
        'quantity'    => 'int',
        'discount'    => 'float',
        'price'       => 'float',
        'total_price' => 'float',
    ];

    /**
     * Boot model events
     */
    protected static function booted(): void
    {
        static::creating(function (OrderProduct $orderProduct) {
            $orderProduct->uuid = (string) Str::uuid();

            // total_price otomatik hesaplanır
            $orderProduct->total_price =
                $orderProduct->price
                * (1 - ($orderProduct->discount / 100))
                * $orderProduct->quantity;
        });
    }

    /**
     * Order relation
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Product relation
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Recalculate total price manually (update senaryoları için)
     */
    public function recalculateTotalPrice(): void
    {
        $this->total_price =
            $this->price
            * (1 - ($this->discount / 100))
            * $this->quantity;

        $this->save();
    }

    /**
     * Find order product by UUID
     */
    public static function findByUuid(string $uuid): self
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
