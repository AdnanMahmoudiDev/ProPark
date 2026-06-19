<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\License;

class LicenseDevice extends Model
{
    protected $fillable = [
        'license_id',
        'seat_number',
        'machine_fingerprint',
        'activated_at',
    ];

    protected $casts = [
        'license_id' => 'integer',
         'seat_number' => 'integer',
        'activated_at' => 'datetime',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
