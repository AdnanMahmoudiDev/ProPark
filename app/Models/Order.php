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

    // وضعیت‌های استاندارد سفارش
    public const STATUS_PENDING   = 'pending';
    public const STATUS_PAID      = 'paid';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_EXPIRED   = 'expired';

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
        return $this->status === self::STATUS_PAID;
    }

    public function isCanceled(): bool
    {
        return in_array($this->status, ['canceled', self::STATUS_CANCELLED, self::STATUS_FAILED], true);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
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
            self::STATUS_PAID      => __('پرداخت شده'),
            self::STATUS_PENDING   => __('در انتظار پرداخت'),
            'canceled',
            self::STATUS_CANCELLED => __('لغو شده'),
            self::STATUS_FAILED    => __('ناموفق'),
            self::STATUS_EXPIRED   => __('منقضی شده'),
            default                => ucfirst($this->status ?? 'نامشخص'),
        };
    }

    /**
     * کلاس‌های استایل وضعیت فاکتور متناسب با تم تیلویند دارک/لایت
     */
    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PAID => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20',
            self::STATUS_PENDING => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20',
            'canceled',
            self::STATUS_CANCELLED => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20',
            self::STATUS_FAILED => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20',
            self::STATUS_EXPIRED => 'bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20',
            default => 'bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20',
        };
    }
}
