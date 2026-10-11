<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlanPrice;
use App\Models\Subscription;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Plan extends Model
{
    protected $fillable = [
        'level',
        'slug',
        'title',
        'description',
        'facilities',
        'max_devices',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'level' => 'integer',
        'facilities' => 'array',
        'max_devices' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function prices()
    {
        return $this->hasMany(PlanPrice::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    /**
     *  ایتم‌های سفارش مرتبط با این پلن
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'purchasable');
    }

}
