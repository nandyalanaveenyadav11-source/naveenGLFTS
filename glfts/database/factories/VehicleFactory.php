<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vin_number' => strtoupper(fake()->unique()->bothify('VIN???###???###???')),
            'license_plate' => strtoupper(fake()->bothify('??-####')),
            'capacity_kg' => fake()->randomFloat(2, 5000, 20000),
            'current_status' => fake()->randomElement(['Active', 'Maintenance', 'Out_of_Service']),
        ];
    }
}
