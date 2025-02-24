<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';

    protected $fillable = [
        'user_id',
        'company_id',
        'transport_id',
        'location',
    ];

    // Un driver appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un driver est lié à une entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function transports()
    {
        return $this->hasMany(Transport::class, 'driver_id');
    }
    public function transport()
    {
        return $this->hasOne(Transport::class, 'id', 'transport_id');
    }


    // Un driver peut recevoir plusieurs affectations de colis
    public function parcelAssignments()
    {
        return $this->hasMany(ParcelAssignment::class, 'driver_id');
    }
}
