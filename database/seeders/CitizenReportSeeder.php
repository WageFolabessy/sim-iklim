<?php

namespace Database\Seeders;

use App\Models\CitizenReport;
use Illuminate\Database\Seeder;

class CitizenReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CitizenReport::create([
            'anomaly_type' => 'flood',
            'location' => 'Jl. Ahmad Yani, Pontianak Selatan',
            'description' => 'Air menggenang setinggi 30cm, lalu lintas tersendat.',
        ]);

        CitizenReport::create([
            'anomaly_type' => 'strong_wind',
            'location' => 'Sungai Raya, Kubu Raya',
            'description' => 'Atap kanopi warga terbang, beberapa dahan pohon patah.',
        ]);

        \App\Models\CitizenReport::create([
            'anomaly_type' => 'other',
            'location' => 'Jl. Adisucipto Km 8',
            'description' => 'Jarak pandang sangat terbatas, hujan turun sangat deras sejak jam 2 siang.'
        ]);
    }
}
