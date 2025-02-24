<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $table = 'parcels';

    protected $fillable = [
        'company_id',
        'identifiant',
        'client_id',
        'zone_id',
        'delivery_address',
        'package_description',
        'package_price',
        'delivery_fee',
        'status',
    ];

    // Un colis appartient à un client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Un colis est associé à une zone de livraison
    public function deliveryZone()
    {
        return $this->belongsTo(DeliveryZone::class, 'zone_id');
    }

    // Un colis appartient à une entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    // Un colis peut avoir plusieurs affectations
    public function parcelAssignments()
    {
        return $this->hasMany(ParcelAssignment::class, 'parcel_id');
    }
}
