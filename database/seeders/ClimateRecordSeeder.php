<?php

namespace Database\Seeders;

use App\Models\ClimateRecord;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClimateRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengamatId = User::where('role', 'pengamat')->value('id') ?? 1;

        ClimateRecord::create([
            'user_id' => $pengamatId,
            'recorded_at' => now()->subDays(2),
            'temperature' => 31.4,
            'humidity' => 78,
            'rainfall' => 12.3,
            'wind_speed' => 8.4,
        ]);

        ClimateRecord::create([
            'user_id' => $pengamatId,
            'recorded_at' => now()->subDays(1),
            'temperature' => 32.9,
            'humidity' => 86,
            'rainfall' => 0,
            'wind_speed' => 5.2,
        ]);

        ClimateRecord::create([
            'user_id' => $pengamatId,
            'recorded_at' => now(),
            'temperature' => 29.8,
            'humidity' => 90,
            'rainfall' => 45.5,
            'wind_speed' => 12.1,
        ]);
    }
}
