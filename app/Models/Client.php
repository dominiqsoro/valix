<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'location',
    ];

    // Un client appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un client est lié à une entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    // Un client peut avoir plusieurs colis
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'client_id');
    }

    // Dans le modèle Client
    public function deliveryZone()
    {
        return $this->belongsTo(DeliveryZone::class);
    }
}
