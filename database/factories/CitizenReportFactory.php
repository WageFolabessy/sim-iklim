<?php

namespace Database\Factories;

use App\Enums\AnomalyType;
use App\Enums\ReportStatus;
use App\Models\CitizenReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CitizenReport>
 */
class CitizenReportFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reporter_name' => fake()->optional(0.7)->name(),
            'location' => fake()->city().', Kalimantan Barat',
            'anomaly_type' => fake()->randomElement(AnomalyType::cases())->value,
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(ReportStatus::cases())->value,
        ];
    }
}
