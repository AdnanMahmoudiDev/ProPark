<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPackage extends Model
{
    protected $fillable = [
        'title',
        'duration_months',
        'price',
        'is_active',
        'sort_order',
        'description',
        'features',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_months' => 'integer',
        'price' => 'integer',
        'features' => 'array',
    ];
}
