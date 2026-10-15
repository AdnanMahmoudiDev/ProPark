<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * تمام سوابق تراکنش‌های مربوط به این سفارش
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    /**
     * آخرین تراکنش انجام‌شده برای این سفارش
     */
    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id')->latestOfMany();
    }

    /**
     * بررسی وضعیت‌های پرداخت
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isCanceled(): bool
    {
        return in_array($this->status, ['canceled', 'cancelled', 'failed']);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * نمایش فرمت‌شده مبلغ قابل پرداخت با کاما
     */
    public function getFormattedPayableAmountAttribute(): string
    {
        return number_format($this->payable_amount);
    }

    /**
     * برچسب وضعیت به فارسی/انگلیسی بر اساس لنگویج سیستم
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid'       => __('پرداخت شده'),
            'pending'    => __('در انتظار پرداخت'),
            'canceled',
            'cancelled'  => __('لغو شده'),
            'failed'     => __('ناموفق'),
            default      => ucfirst($this->status ?? 'نامشخص'),
        };
    }

    /**
     * کلاس‌های استایل وضعیت فاکتور متناسب با تم تیلویند دارک/لایت
     */
    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20',
            'pending' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20',
            'canceled',
            'cancelled' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20',
            'failed' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20',
            default => 'bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20',
        };
    }
}
