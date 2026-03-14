<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckCertification;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// Shipments
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/shipments', [ShipmentController::class, 'index']);
});

// Helper for Search Dropdowns
Route::get('/locations', function () {
    return response()->json([
        'origins' => \App\Models\Shipment::distinct()->pluck('origin'),
        'destinations' => \App\Models\Shipment::distinct()->pluck('destination'),
    ]);
});

// Vehicles
Route::get('/vehicles', function () {
    return response()->json(\App\Models\Vehicle::select('id', 'license_plate', 'vin_number')->get());
});

// Vehicle remaining capacity
Route::get('/vehicles/{id}/remaining-capacity', [VehicleController::class, 'remainingCapacity']);
