<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceLogFactory> */
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'service_type',
        'cost',
        'date_of_service',
    ];

    protected $casts = [
        'cost' => 'encrypted',
        'date_of_service' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
