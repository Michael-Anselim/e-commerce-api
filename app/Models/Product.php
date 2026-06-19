<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'quantity',
        'price',
        'status',
    ];

    public function shoppingCarts(): HasMany
    {
        return $this->hasMany(ShoppingCart::class);
    }
}
