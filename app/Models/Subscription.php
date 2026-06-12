<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\License;

class Subscription extends Model
{
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
}
