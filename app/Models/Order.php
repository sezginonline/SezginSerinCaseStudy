<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'float',
    ];

    /**
     * Boot model events
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->uuid = (string) Str::uuid();
            $order->reference_no = strtoupper(Str::random(10));
            $order->total_price ??= 0;
        });
    }

    /**
     * Order belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has many OrderProducts
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Recalculate total price from order products
     */
    public function recalculateTotalPrice(): void
    {
        $this->total_price = $this->orderProducts()->sum('total_price');
        $this->save();
    }

    /**
     * Find order by UUID
     */
    public static function findByUuid(string $uuid): self
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
