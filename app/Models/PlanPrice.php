<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
