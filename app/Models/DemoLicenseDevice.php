<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoLicenseDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_fingerprint',
        'trial_started_at',
        'trial_expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'trial_started_at' => 'datetime',
            'trial_expires_at' => 'datetime',
        ];
    }
}
