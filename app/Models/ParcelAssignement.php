<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelAssignment extends Model
{
    protected $table = 'parcel_assignments';

    protected $fillable = [
        'parcel_id',
        'company_id',
        'driver_id',
        'assigned_at',
    ];

    // Une affectation concerne un colis
    public function parcel()
    {
        return $this->belongsTo(Parcel::class, 'parcel_id');
    }

    // Une affectation est reliée à un driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // Une affectation est réalisée par une entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
