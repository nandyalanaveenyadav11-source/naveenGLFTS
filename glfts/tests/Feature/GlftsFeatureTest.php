<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Shipment;
use App\Models\Driver;
use App\Services\ShipmentService;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckVehicleCapacity;

class GlftsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_cannot_be_overloaded()
    {
        $vehicle = Vehicle::factory()->create(['capacity_kg' => 1000]);
        $shipment1 = Shipment::factory()->create(['weight_kg' => 600, 'status' => 'Loading']);
        $vehicle->shipments()->attach($shipment1->id);

        $rule = new CheckVehicleCapacity(500); 

        $passed = true;
        $rule->validate('vehicle_id', $vehicle->id, function($message) use (&$passed) {
            $passed = false;
        });

        $this->assertFalse($passed, 'The vehicle should be considered overloaded.');
    }

    public function test_driver_without_proper_certification_cannot_transport_hazardous_cargo()
    {
        $driver = Driver::factory()->create(['certification_level' => 'Standard']);
        
        $response = $this->postJson('/api/shipments/1/assign', [
            'driver_id' => $driver->id,
            'cargo_type' => 'Hazardous'
        ]);

        $response->assertStatus(403);
        $response->assertJson(['error' => 'Driver lacks required certification for Hazardous cargo.']);
    }

    public function test_shipment_cannot_skip_loading_phase()
    {
        $shipment = Shipment::factory()->create(['status' => 'Pending']);
        $service = new ShipmentService();

        $this->expectException(Exception::class);
        $service->updateStatus($shipment, 'In_Transit'); 
    }
}
