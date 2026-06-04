<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use App\Models\User;
use App\Models\WeatherAlert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        $admin = User::factory()->create([
            'name' => 'Administrator BMKG',
            'email' => 'admin@bmkg.go.id',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin->value,
        ]);

        // Pengamat account
        $pengamat = User::factory()->create([
            'name' => 'Petugas Pengamat',
            'email' => 'pengamat@bmkg.go.id',
            'password' => Hash::make('password'),
            'role' => UserRole::Pengamat->value,
        ]);

        // 100 climate records across the last 5 years, all attributed to the pengamat.
        // Spread evenly across months so the "current month" aggregation yields data.
        ClimateRecord::factory(100)->create(['user_id' => $pengamat->id]);

        // 5 citizen reports with randomized statuses
        CitizenReport::factory(5)->create();

        // 3 weather alerts
        WeatherAlert::factory(3)->create();
    }
}
