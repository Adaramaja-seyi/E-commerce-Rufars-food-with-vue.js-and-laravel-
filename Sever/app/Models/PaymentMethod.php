<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'last4',
        'expiry',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Automatically unset other default payment methods when setting a new default
    protected static function booted(): void
    {
        static::saving(function (PaymentMethod $paymentMethod) {
            if ($paymentMethod->is_default) {
                static::where('user_id', $paymentMethod->user_id)
                    ->where('id', '!=', $paymentMethod->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
