<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStat extends Model
{
    use HasFactory;

    protected $table = 'delivery_stats';

    protected $fillable = [
        'company_id',
        'user_id',
        'total_clients',
        'total_delivery_amount',
        'total_parcel_amount',
        'total_parcels_today',
        'pending_parcels',
        'in_transit_parcels',
        'delivered_parcels',
        'total_parcel_value'
    ];

    // Relations

    // Relation vers la société de livraison
    public function company()
    {
        return $this->belongsTo(DeliveryCompany::class, 'company_id');
    }

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
