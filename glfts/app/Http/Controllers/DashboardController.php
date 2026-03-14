<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Live Dashboard Stats
     * 
     * Get a summary of the fleet status, including counts of vehicles currently in motion versus those that are idle.
     * 
     * @group Dashboard
     * 
     * @response {
     *  "vehicles_in_motion": 6,
     *  "vehicles_idle": 4
     * }
     */
    public function index()
    {
        $vehicles = Vehicle::with('shipments')->get();
        
        $grouped = $vehicles->groupBy(function ($vehicle) {
            $inMotion = $vehicle->shipments->contains('status', 'In_Transit');
            return $inMotion ? 'vehicles_in_motion' : 'vehicles_idle';
        });

        return response()->json([
            'vehicles_in_motion' => $grouped->get('vehicles_in_motion', collect())->count(),
            'vehicles_idle' => $grouped->get('vehicles_idle', collect())->count(),
        ]);
    }
}
