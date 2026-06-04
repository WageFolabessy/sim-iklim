<?php

namespace Database\Seeders;

use App\Models\WeatherAlert;
use Illuminate\Database\Seeder;

class WeatherAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WeatherAlert::create([
            'level' => 'waspada',
            'title' => 'Suhu Udara Tinggi',
            'area' => 'Sintang, Melawi, Sekadau',
            'body' => 'Suhu maksimum diperkirakan mencapai 35°C. Risiko kebakaran lahan meningkat. Hindari aktivitas membakar di lahan terbuka.',
        ]);

        WeatherAlert::create([
            'level' => 'bahaya',
            'title' => 'Hujan Lebat Disertai Angin Kencang',
            'area' => 'Ketapang, Kayong Utara',
            'body' => 'Potensi hujan dengan intensitas lebat (>50mm/jam) disertai angin kencang dan petir. Warga pesisir diimbau waspada gelombang tinggi.',
        ]);
    }
}
