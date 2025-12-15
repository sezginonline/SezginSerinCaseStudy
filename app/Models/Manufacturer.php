<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

    protected $fillable = [
        'uuid',
        'name',
    ];

    /**
     * Manufacturer -> Products (1-N)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Find manufacturer by UUID
     */
    public static function findByUuid(string $uuid): self
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
