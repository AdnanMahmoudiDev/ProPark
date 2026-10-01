<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

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

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * منطق تمدید تاریخ انقضا
     */
    public function extend(int $months): void
    {
        $currentExpiry = $this->expires_at;

        // اگر تاریخ انقضا در گذشته است، از زمان حال شروع کن
        if ($currentExpiry->isPast()) {
            $this->expires_at = Carbon::now()->addMonths($months);
        } else {
            // اگر هنوز فعال است، به تاریخ انقضای قبلی اضافه کن
            $this->expires_at = $currentExpiry->addMonths($months);
        }

        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }
}
