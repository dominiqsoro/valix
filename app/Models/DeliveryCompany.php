<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    protected $table = 'delivery_companies';

    protected $fillable = [
        'name',
        'manager_id',
    ];

    // Relation vers le manager (utilisateur)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Relation vers les clients associés
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Relation vers les chauffeurs de la société
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    // Relation vers les moyens de transport
    public function transports()
    {
        return $this->hasMany(Transport::class);
    }
}
