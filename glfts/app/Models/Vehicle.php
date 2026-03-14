<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'vin_number',
        'license_plate',
        'capacity_kg',
        'current_status',
    ];

    protected $casts = [
        'capacity_kg' => 'float',
    ];

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'vehicle_shipment');
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
