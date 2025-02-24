<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = 'transports';

    protected $fillable = [
        'company_id',
        'transport_type',
        'statut',
        'details',
        'color',
        'driver_id',
    ];

    // Un moyen de transport appartient à une entreprise
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    // Un moyen de transport peut être affecté à un driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }

}
