<?php

namespace Database\Seeders;

use App\Models\WeatherAlert;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class WeatherAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = ['waspada', 'bahaya', 'info'];

        $areas = [
            'Sintang, Melawi, Sekadau',
            'Ketapang, Kayong Utara',
            'Pontianak, Kubu Raya, Mempawah',
            'Singkawang, Bengkayang, Sambas',
            'Kapuas Hulu',
            'Sanggau, Sekadau',
        ];

        $titles = [
            'Peringatan Dini Cuaca Ekstrem',
            'Waspada Banjir Bandang',
            'Hujan Lebat Disertai Angin Kencang',
            'Gelombang Tinggi di Pesisir',
            'Suhu Udara Tinggi, Rawan Karhutla',
            'Waspada Puting Beliung',
        ];

        $bodies = [
            'Potensi hujan dengan intensitas lebat (>50mm/jam) disertai angin kencang dan petir. Warga pesisir diimbau waspada gelombang tinggi.',
            'Suhu maksimum diperkirakan mencapai 35°C. Risiko kebakaran lahan meningkat. Hindari aktivitas membakar di lahan terbuka.',
            'Diprakirakan terjadi hujan sedang-lebat yang dapat disertai kilat/petir dan angin kencang.',
            'Waspada potensi banjir rob dan gelombang tinggi yang dapat mengganggu aktivitas warga pesisir.',
            'Angin kencang terpantau dengan kecepatan di atas 40 km/jam. Hindari berteduh di bawah baliho atau pohon rapuh.',
            'Bagi warga yang bermukim di bantaran sungai diharapkan waspada terhadap potensi luapan air imbas curah hujan di daerah hulu.',
        ];

        $records = [];
        for ($i = 0; $i < 20; $i++) {
            $records[] = [
                'level' => Arr::random($levels),
                'title' => Arr::random($titles),
                'area' => Arr::random($areas),
                'body' => Arr::random($bodies),
                'created_at' => Carbon::now()->subDays(rand(0, 14))->subHours(rand(0, 23)),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach (array_chunk($records, 100) as $chunk) {
            WeatherAlert::insert($chunk);
        }
    }
}
