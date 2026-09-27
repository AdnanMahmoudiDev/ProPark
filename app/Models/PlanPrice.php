<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Cart;

class PlanPrice extends Model
{
    protected $fillable = [
        'plan_id',
        'duration_months',
        'price',
        'discount_percent',
        'original_price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'plan_id' => 'integer',
        'duration_months' => 'integer',
        'price' => 'integer',
        'discount_percent' => 'integer',
        'original_price' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * افزودن خودکار صفت به خروجی‌های آرایه یا JSON مدل
     */
    protected $appends = [
        'duration_label',
    ];

    /**
     * تبدیل هوشمند مدت زمان ماه به سال و ماه
     * مثال:
     * 1 => "1 ماهه"
     * 12 => "1 ساله"
     * 18 => "1 سال و 6 ماهه"
     * 120 => "10 ساله"
     */
    protected function durationLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                $months = (int) $this->duration_months;

                if ($months <= 0) {
                    return "نامشخص";
                }

                if ($months < 12) {
                    return "{$months} ماهه";
                }

                $years = intdiv($months, 12);
                $remainingMonths = $months % 12;

                if ($remainingMonths === 0) {
                    return "{$years} ساله";
                }

                return "{$years} سال و {$remainingMonths} ماهه";
            }
        );
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
