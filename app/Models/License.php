<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subscription;
use App\Models\LicenseDevice;

class License extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'license_key',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subscription_id' => 'integer',
        'last_used_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function devices()
    {
        return $this->hasMany(LicenseDevice::class);
    }
}
