<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $table = 'delivery_zones';

    protected $fillable = [
        'zone_name',
        'description',
    ];

    // Une zone de livraison peut concerner plusieurs colis
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'zone_id');
    }
}
