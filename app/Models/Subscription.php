<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Morilog\Jalali\Jalalian;

class Subscription extends Model
{
    public const STATUS_PENDING     = 'pending';
    public const STATUS_ACTIVE      = 'active';
    public const STATUS_CANCELED    = 'canceled';
    public const STATUS_DEACTIVATED = 'deactivated';

    protected $fillable = [
        'user_id',
        'plan_id',
        'started_at',
        'status',
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'plan_id'    => 'integer',
        'started_at' => 'datetime',
        'status'     => 'string',
    ];

    /* =======================
     | Relationships
     ======================= */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function license(): HasOne
    {
        return $this->hasOne(License::class);
    }

    /**
     * همه رکوردهای پشتیبانی مرتبط با این اشتراک
     */
    public function supports(): HasMany
    {
        return $this->hasMany(SubscriptionSupport::class);
    }

    /**
     * پشتیبانی فعال فعلی (جدیدترین رکورد active که منقضی نشده)
     */
    public function activeSupport(): HasOne
    {
        return $this->hasOne(SubscriptionSupport::class)
            ->where('status', SubscriptionSupport::STATUS_ACTIVE)
            ->where('expires_at', '>=', now())
            ->latestOfMany();
    }

    /**
     * آخرین رکورد پشتیبانی ثبت‌شده برای این اشتراک (چه فعال باشد چه منقضی)
     */
    public function latestSupport(): HasOne
    {
        return $this->hasOne(SubscriptionSupport::class)->latestOfMany();
    }

    /* =======================
     | Status helpers
     ======================= */

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getEffectiveStatusAttribute(): string
    {
        return $this->status;
    }

    /* =======================
     | Scopes
     ======================= */

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /* =======================
     | Jalali accessors
     ======================= */

    public function getStartedAtJalaliAttribute(): ?string
    {
        if (!$this->started_at) {
            return null;
        }

        return Jalalian::fromCarbon($this->started_at)->format('Y/m/d H:i');
    }
}
