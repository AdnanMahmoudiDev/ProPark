<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    // Statuses
    public const STATUS_PENDING   = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED  = 'canceled';

    // Types (برای پلن‌ها)
    public const TYPE_PURCHASE   = 'purchase';
    public const TYPE_RENEW      = 'renew';
    public const TYPE_UPGRADE    = 'upgrade';
    public const TYPE_DOWNGRADE  = 'downgrade';

    // Types (برای پکیج‌های پشتیبانی) - اگر جای دیگری هم از type استفاده می‌کنی اینها کمک می‌کند
    public const TYPE_SUPPORT = 'support';

    protected $fillable = [
        'user_id',

        // plan purchase
        'plan_id',
        'plan_price_id',

        // support package purchase
        'support_package_id',

        // shared
        'type',
        'status',
    ];

    protected $casts = [
        'user_id'            => 'integer',

        'plan_id'            => 'integer',
        'plan_price_id'      => 'integer',

        'support_package_id' => 'integer',

        'type'               => 'string',
        'status'             => 'string',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function planPrice(): BelongsTo
    {
        return $this->belongsTo(PlanPrice::class);
    }

    /**
     * رابطه پکیج پشتیبانی
     * نکته: فرض بر این است که مدل SupportPackage در App\Models\SupportPackage وجود دارد.
     * اگر namespace/نام مدل فرق دارد، همینجا اصلاحش کن.
     */
    public function supportPackage(): BelongsTo
    {
        return $this->belongsTo(SupportPackage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Status)
    |--------------------------------------------------------------------------
    */

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CANCELED);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Type)
    |--------------------------------------------------------------------------
    */

    public function scopePurchase(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_PURCHASE);
    }

    public function scopeRenew(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_RENEW);
    }

    public function scopeUpgrade(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_UPGRADE);
    }

    public function scopeDowngrade(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_DOWNGRADE);
    }

    public function scopeSupport(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_SUPPORT);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Other)
    |--------------------------------------------------------------------------
    */

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
