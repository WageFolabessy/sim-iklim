<?php

namespace Database\Factories;

use App\Models\ClimateRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClimateRecord>
 */
class ClimateRecordFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Realistic Kalimantan Barat climate ranges:
        // Temp: 24–35°C | Humidity: 70–98% | Rainfall: 0–250mm
        return [
            'user_id' => User::factory(),
            'recorded_at' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'temperature' => fake()->randomFloat(2, 24.0, 35.0),
            'humidity' => fake()->numberBetween(70, 98),
            'rainfall' => fake()->randomFloat(2, 0.0, 250.0),
        ];
    }
}
