<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_code' => fake()->uuid(),
            'origin' => fake()->city(),
            'destination' => fake()->city(),
            'weight_kg' => fake()->randomFloat(2, 100, 5000),
            'cargo_type' => fake()->randomElement(['Hazardous', 'Perishable', 'Standard']),
            'status' => fake()->randomElement(['Pending', 'Loading', 'In_Transit', 'Delivered']),
        ];
    }
}
