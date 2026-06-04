<?php

namespace Database\Factories;

use App\Models\WeatherAlert;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeatherAlert>
 */
class WeatherAlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level' => $this->faker->randomElement(['bahaya', 'waspada', 'info']),
            'title' => $this->faker->sentence(),
            'area' => $this->faker->city(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
