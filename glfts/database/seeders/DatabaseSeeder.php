<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Demo Users
        \App\Models\User::factory()->create([
            'name' => 'Admin (Operations Manager)',
            'email' => 'admin@glfts.com',
            'password' => bcrypt('password123'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dispatcher (Officer)',
            'email' => 'dispatcher@glfts.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Create 10 Vehicles
        $vehicles = \App\Models\Vehicle::factory(10)->create();

        // 3. Create 5 Drivers
        $drivers = \App\Models\Driver::factory(5)->create();

        // 4. Create 20 Shipments
        $shipments = \App\Models\Shipment::factory(20)->create([
            'driver_id' => function() use ($drivers) {
                return $drivers->random()->id;
            }
        ]);
        
        // 5. Link Shipments to Vehicles randomly (and respect capacity in real app, but for seed we random)
        foreach ($vehicles as $vehicle) {
            $vehicle->shipments()->attach($shipments->random(rand(2, 4))->pluck('id'));
        }

        // 6. Add Maintenance Logs for each vehicle
        foreach ($vehicles as $vehicle) {
            // Add at least one old log and one recent log
            \App\Models\MaintenanceLog::factory()->create([
                'vehicle_id' => $vehicle->id,
                'date_of_service' => now()->subMonths(rand(7, 12)), // Overdue
            ]);

            \App\Models\MaintenanceLog::factory()->create([
                'vehicle_id' => $vehicle->id,
                'date_of_service' => now()->subMonths(rand(1, 5)), // Recent
            ]);
        }
    }
}
