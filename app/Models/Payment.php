<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING    = 'pending';
    public const STATUS_SUCCESSFUL = 'successful';
    public const STATUS_FAILED     = 'failed';
    public const STATUS_CANCELLED  = 'cancelled';

    protected $fillable = [
        'order_id',
        'user_id',
        'gateway',
        'amount',
        'currency',
        'status',
        'authority',
        'reference_id',
        'card_pan',
        'failure_code',
        'failure_message',
        'request_payload',
        'response_payload',
        'paid_at',
    ];

    protected $casts = [
        'amount'           => 'integer',
        'request_payload'  => 'array',
        'response_payload' => 'array',
        'paid_at'          => 'datetime',
    ];

    /**
     * سفارش مرتبط با تراکنش
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * کاربر پرداخت‌کننده
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * بررسی موفق بودن پرداخت
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }
}
