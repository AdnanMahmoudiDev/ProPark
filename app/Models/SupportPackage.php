<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPackage extends Model
{
    /**
     * ویژگی‌هایی که قابلیت انتساب جمعی (Mass Assignment) دارند.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'duration_months',
        'price',
        'original_price',
        'discount_percent',
        'is_active',
        'sort_order',
        'description',
        'features',
    ];

    /**
     * کست کردن تایپ ویژگی‌ها به انواع داده‌های استاندارد پی‌اچ‌پی.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'duration_months' => 'integer',
        'price' => 'integer',
        'original_price' => 'integer',
        'discount_percent' => 'integer',
        'sort_order' => 'integer',
        'features' => 'array',
    ];

    /**
     * بررسی اینکه آیا پکیج تخفیف فعال دارد یا خیر.
     */
    public function getHasDiscountAttribute(): bool
    {
        return ($this->discount_percent ?? 0) > 0;
    }

    /**
     * محاسبه مبلغ عددی تخفیف (تومان).
     */
    public function getDiscountAmountAttribute(): int
    {
        if (! $this->has_discount) {
            return 0;
        }

        $base = $this->original_price ?: $this->price;

        return (int) max(0, $base - $this->price);
    }
}
