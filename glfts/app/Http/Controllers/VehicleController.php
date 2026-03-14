<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Vehicle Remaining Capacity
     * 
     * Calculate the remaining available payload for a specific vehicle before adding new shipments.
     * 
     * @group Vehicle Management
     * @urlParam id int required The ID of the vehicle. Example: 1
     * 
     * @response {
     *  "vehicle_capacity": 5000.0,
     *  "current_load": 2500.0,
     *  "remaining_capacity": 2500.0
     * }
     */
    public function remainingCapacity($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $currentLoad = $vehicle->shipments()
            ->whereIn('status', ['Loading', 'In_Transit'])
            ->sum('weight_kg');

        return response()->json([
            'vehicle_capacity' => $vehicle->capacity_kg,
            'current_load' => (float)$currentLoad,
            'remaining_capacity' => $vehicle->capacity_kg - $currentLoad,
        ]);
    }
}
