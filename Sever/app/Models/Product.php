<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'rating',
        'reviews',
        'category',
        'nutritional_info',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'nutritional_info' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
