<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'user_id',
        'name',
    ];

    // Une entreprise appartient à un utilisateur (manager)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Une entreprise peut avoir plusieurs clients
    public function clients()
    {
        return $this->hasMany(Client::class, 'company_id', 'company_id');
    }

    // Une entreprise peut employer plusieurs drivers
    public function drivers()
    {
        return $this->hasMany(Driver::class, 'company_id', 'company_id');
    }

    // Une entreprise peut avoir plusieurs moyens de transport
    public function transports()
    {
        return $this->hasMany(Transport::class, 'company_id', 'company_id');
    }

    // Une entreprise peut avoir plusieurs colis
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'company_id', 'company_id');
    }

    // Une entreprise peut avoir plusieurs affectations de colis
    public function parcelAssignments()
    {
        return $this->hasMany(ParcelAssignment::class, 'company_id', 'company_id');
    }
}
