<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * List Shipments
     * 
     * Get a list of all shipments with optional geospatial filtering by origin and destination.
     * 
     * @group Shipment Tracking
     * @queryParam origin string Filter shipments by origin city. Example: London
     * @queryParam destination string Filter shipments by destination city. Example: Paris
     * 
     * @response [
     *  {
     *    "id": 1,
     *    "tracking_code": "550e8400-e29b-41d4-a716-446655440000",
     *    "origin": "London",
     *    "destination": "Paris",
     *    "weight_kg": 2500.5,
     *    "cargo_type": "Standard",
     *    "status": "In_Transit"
     *  }
     * ]
     */
    public function index(Request $request)
    {
        $query = Shipment::query();

        if ($request->has('origin')) {
            $query->where('origin', 'like', '%' . $request->input('origin') . '%');
        }

        if ($request->has('destination')) {
            $query->where('destination', 'like', '%' . $request->input('destination') . '%');
        }

        return response()->json($query->get());
    }
}
