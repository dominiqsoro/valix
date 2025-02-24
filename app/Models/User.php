<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'role',
        'validation_code',
        'is_verified',
        'status',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Un utilisateur (manager) peut avoir une entreprise
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    // Un utilisateur peut être lié à un client
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    // Un utilisateur peut être lié à un driver
    public function driver()
    {
        return $this->hasOne(Driver::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

}
