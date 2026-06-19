<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
  
    //  constants (جلوگیری از magic string)
    

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';

    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_RENEW = 'renew';
    public const TYPE_UPGRADE = 'upgrade';
    public const TYPE_DOWNGRADE = 'downgrade';

    
    //fillable

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_price_id',
        'type',
        'status',
    ];

    // casting
  

    protected $casts = [
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'plan_price_id' => 'integer',
        'type' => 'string',
        'status' => 'string',
    ];

    //  relationships
    

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

    // scopes (service layer)
   

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
