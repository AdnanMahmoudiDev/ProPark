<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal_amount',
        'discount_amount',
        'payable_amount',
        'currency',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'subtotal_amount' => 'integer',
        'discount_amount' => 'integer',
        'payable_amount'  => 'integer',
        'paid_at'         => 'datetime',
    ];

    /**
     * کاربری که این سفارش متعلق به اوست
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * آیتم‌های سفارش (پکیج‌ها و پلن‌ها)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * سوابق تراکنش‌های مربوط به این سفارش
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * بررسی اینکه آیا سفارش پرداخت شده است یا خیر
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
