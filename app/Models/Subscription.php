<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'name',
        'price',
        'duration',
        'details',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'status' => 'string',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'subscription_id');
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
