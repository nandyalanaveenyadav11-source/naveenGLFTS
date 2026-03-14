<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ShipmentObserver;

#[ObservedBy([ShipmentObserver::class])]
class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'tracking_code',
        'driver_id',
        'origin',
        'destination',
        'weight_kg',
        'cargo_type',
        'status',
    ];

    protected $casts = [
        'weight_kg' => 'float',
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_shipment');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
