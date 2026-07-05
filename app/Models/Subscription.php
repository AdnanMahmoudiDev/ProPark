<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\License;
use Morilog\Jalali\Jalalian;

class Subscription extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_DEACTIVATED = 'deactivated';

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_price_id',
        'started_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'plan_price_id' => 'integer',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'string',
    ];


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

    public function license()
    {
        return $this->hasOne(License::class);
    }


    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE && ! $this->isExpired();
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === self::STATUS_ACTIVE && $this->isExpired()) {
            return self::STATUS_DEACTIVATED;
        }

        return $this->status;
    }



    public function scopeActive($query)
    {
        return $query
            ->where('status', self::STATUS_ACTIVE)
            ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());
    }



    public function getStartedAtJalaliAttribute(): ?string
    {
        if (!$this->started_at) {
            return null;
        }

        return Jalalian::fromCarbon($this->started_at)->format('Y/m/d H:i');
    }

    public function getExpiresAtJalaliAttribute(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }

        return Jalalian::fromCarbon($this->expires_at)->format('Y/m/d H:i');
    }
}
