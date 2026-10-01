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
        // در سیستم جدید لایسنس مادام‌العمر، plan_price_id و expires_at مبنای کار نیستند
        // ولی اگر هنوز در DB یا بعضی جاها استفاده می‌شوند، فعلاً نگه داشتنشون مشکلی نداره
        'plan_price_id',
        'started_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'user_id'       => 'integer',
        'plan_id'       => 'integer',
        'plan_price_id' => 'integer',
        'started_at'    => 'datetime',
        'expires_at'    => 'datetime',
        'status'        => 'string',
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

    // اگر PlanPrice را در سیستم Lifetime دیگر استفاده نمی‌کنی، می‌توانی بعداً حذفش کنی
    public function planPrice(): BelongsTo
    {
        return $this->belongsTo(PlanPrice::class);
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

    /* =======================
     | Status helpers
     ======================= */

    /**
     * در سیستم Lifetime، "فعال بودن" صرفاً با status مشخص می‌شود (نه expires_at)
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * این متد دیگر برای اشتراک lifetime معنی ندارد، ولی برای جلوگیری از شکست جاهای قدیمی نگه می‌داریم.
     * اگر واقعاً ستون expires_at حذف شده، می‌توانیم این را هم حذف کنیم.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * در سیستم جدید بهتر است effective_status فقط بر اساس status باشد.
     * (منطق expires_at مربوط به سیستم اشتراکی زمانی بود)
     */
    public function getEffectiveStatusAttribute(): string
    {
        return $this->status;
    }

    /* =======================
     | Scopes
     ======================= */

    /**
     * در سیستم Lifetime، active یعنی status=active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * این scope در سیستم Lifetime کاربرد قبلی را ندارد.
     * فعلاً نگه می‌داریم تا اگر جایی صدا زده شد، خطا ندهد؛
     * اما خروجی‌اش منطقیِ سابق را تضمین نمی‌کند.
     */
    public function scopeExpired($query)
    {
        return $query
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());
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

    /**
     * برای Lifetime ممکن است expires_at null باشد؛ در این صورت null برمی‌گردانیم
     */
    public function getExpiresAtJalaliAttribute(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }

        return Jalalian::fromCarbon($this->expires_at)->format('Y/m/d H:i');
    }
}
