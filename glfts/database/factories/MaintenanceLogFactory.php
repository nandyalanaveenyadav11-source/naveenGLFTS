<?php

namespace Database\Factories;

use App\Models\MaintenanceLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaintenanceLog>
 */
class MaintenanceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_type' => fake()->randomElement(['Oil Change', 'Brake Inspection', 'Tire Rotation', 'Engine Tuning', 'Transmission Flush']),
            'cost' => fake()->randomFloat(2, 50, 500),
            'date_of_service' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
