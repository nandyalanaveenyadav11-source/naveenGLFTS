<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckVehicleCapacity implements ValidationRule
{
    protected $shipmentWeight;
    protected $shipmentId;

    public function __construct($shipmentWeight, $shipmentId = null)
    {
        $this->shipmentWeight = $shipmentWeight;
        $this->shipmentId = $shipmentId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $vehicle = \App\Models\Vehicle::find($value);
        if (!$vehicle) {
            $fail('The selected vehicle does not exist.');
            return;
        }

        $currentLoad = $vehicle->shipments()
            ->when($this->shipmentId, function ($query) {
                $query->where('shipments.id', '!=', $this->shipmentId);
            })
            ->whereIn('status', ['Loading', 'In_Transit'])
            ->sum('weight_kg');

        if (($currentLoad + $this->shipmentWeight) > $vehicle->capacity_kg) {
            $fail('The total shipment weight exceeds the vehicle capacity.');
        }
    }
}
