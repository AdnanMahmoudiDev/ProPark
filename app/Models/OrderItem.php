<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'purchasable_type',
        'purchasable_id',
        'title',
        'unit_price',
        'discount_amount',
        'final_amount',
        'quantity',
        'metadata',
    ];

    protected $casts = [
        'unit_price'      => 'integer',
        'discount_amount' => 'integer',
        'final_amount'    => 'integer',
        'quantity'        => 'integer',
        'metadata'        => 'array',
    ];

    /**
     * سفارش والد
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * رابطه چندریختی با Plan یا SupportPackage
     */
    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }
}
