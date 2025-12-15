<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total',
        'status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' .
                    date('Y') . '-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
