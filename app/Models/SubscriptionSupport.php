<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Morilog\Jalali\Jalalian;

class SubscriptionSupport extends Model
{
    use HasFactory;

    protected $table = 'subscription_supports';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'subscription_id',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'starts_at'  => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * اکسسورهایی که باید به آرایه/جیسون مدل اضافه شوند
     */
    protected $appends = [
        'starts_at_jalali',
        'expires_at_jalali',
        'is_active',
        'is_expired',
    ];

    /**
     * رابطه با اشتراک (لایسنس) مربوطه
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * دسترسی مستقیم به کاربر دارنده این پشتیبانی از طریق جدول اشتراک‌ها
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Subscription::class,
            'id',              // کلید اصلی در جدول subscriptions
            'id',              // کلید اصلی در جدول users
            'subscription_id', // کلید خارجی در جدول subscription_supports
            'user_id'          // کلید خارجی در جدول subscriptions
        );
    }

    /**
     * اکسسور تاریخ شروع به شمسی
     */
    protected function startsAtJalali(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->starts_at ? Jalalian::fromCarbon($this->starts_at)->format('Y/m/d') : '—'
        );
    }

    /**
     * اکسسور تاریخ انقضای پشتیبانی به شمسی
     */
    protected function expiresAtJalali(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expires_at ? Jalalian::fromCarbon($this->expires_at)->format('Y/m/d') : '—'
        );
    }

    /**
     * آیا پشتیبانی هم‌اکنون فعال و معتبر است؟
     */
    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status !== self::STATUS_CANCELLED &&
                          $this->expires_at &&
                          $this->expires_at->isFuture()
        );
    }

    /**
     * آیا پشتیبانی منقضی شده است؟
     */
    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expires_at && $this->expires_at->isPast()
        );
    }

    /**
     * اسکوپ کوئری برای رکوردهای پشتیبانی فعال
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', self::STATUS_CANCELLED)
                     ->where('expires_at', '>=', now());
    }

    /**
     * اسکوپ کوئری برای رکوردهای پشتیبانی منقضی‌شده
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * منطق تمدید تاریخ انقضای پشتیبانی
     */
    public function extend(int $months): void
    {
        $currentExpiry = $this->expires_at;

        // اگر انقضا ثبت نشده یا در گذشته است، مبدا تمدید زمان حال خواهد بود
        if (! $currentExpiry || $currentExpiry->isPast()) {
            $this->expires_at = Carbon::now()->addMonths($months);
        } else {
            // در غیر این صورت به انتهای دوره جاری اضافه می‌شود
            $this->expires_at = $currentExpiry->copy()->addMonths($months);
        }

        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }


}
