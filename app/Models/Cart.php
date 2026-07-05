<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{


    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';



    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_RENEW = 'renew';
    public const TYPE_UPGRADE = 'upgrade';
    public const TYPE_DOWNGRADE = 'downgrade';



    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_price_id',
        'type',
        'status',
    ];



    protected $casts = [
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'plan_price_id' => 'integer',
        'type' => 'string',
        'status' => 'string',
    ];

    //روابط

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function planPrice()
    {
        return $this->belongsTo(PlanPrice::class);
    }



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



    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
