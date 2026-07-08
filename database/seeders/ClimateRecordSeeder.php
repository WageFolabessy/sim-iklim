<?php

namespace Database\Seeders;

use App\Models\ClimateRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClimateRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengamatId = User::where('role', 'pengamat')->value('id') ?? 1;
        $records = [];
        $start = Carbon::now()->startOfYear();
        $end = Carbon::now()->startOfDay();

        while ($start->lte($end)) {
            $records[] = [
                'user_id' => $pengamatId,
                'recorded_at' => $start->format('Y-m-d'),
                'temperature' => round(rand(260, 350) / 10, 2),
                'humidity' => rand(65, 100),
                'rainfall' => rand(1, 10) > 4 ? round(rand(20, 1500) / 10, 2) : 0,
                'wind_speed' => round(rand(20, 200) / 10, 2),
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $start->addDay();
        }

        foreach (array_chunk($records, 100) as $chunk) {
            ClimateRecord::insert($chunk);
        }
    }
}
