<?php

namespace Database\Seeders;

use App\Models\CitizenReport;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CitizenReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Pontianak Selatan', 'Sintang Kota', 'Kapuas Hulu',
            'Sungai Pinyuh', 'Singkawang', 'Ketapang', 'Sambas',
            'Mempawah', 'Kubu Raya', 'Sanggau', 'Bengkayang',
        ];

        $descriptions = [
            'Air sungai meluap menggenangi jalan raya hingga 30cm.',
            'Pohon tumbang menghalangi lalu lintas utama.',
            'Hujan sangat deras disertai petir, jarak pandang terbatas.',
            'Kekeringan parah membuat sumur warga mulai surut.',
            'Angin kencang merusak beberapa atap rumah warga.',
            'Banjir bandang menerjang perumahan warga di bantaran sungai.',
            'Hujan badai mengakibatkan atap sekolah rusak.',
            'Cuaca sangat panas, rawan terjadi kebakaran lahan gambut.',
            'Angin puting beliung terpantau di daerah pesisir pantai.',
        ];

        $anomalies = [
            'flood', 'drought', 'strong_wind', 'other',
        ];

        $records = [];
        for ($i = 0; $i < 50; $i++) {
            $records[] = [
                'anomaly_type' => Arr::random($anomalies),
                'location' => Arr::random($locations),
                'description' => Arr::random($descriptions),
                'created_at' => Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(1, 1440)),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach (array_chunk($records, 100) as $chunk) {
            CitizenReport::insert($chunk);
        }
    }
}
