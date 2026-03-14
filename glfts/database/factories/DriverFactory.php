<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'license_number' => strtoupper(fake()->unique()->bothify('DL-########')),
            'certification_level' => fake()->randomElement(['Standard', 'Hazmat', 'Heavy']),
            'years_of_experience' => fake()->numberBetween(1, 20),
            'is_on_trip' => false,
        ];
    }
}
