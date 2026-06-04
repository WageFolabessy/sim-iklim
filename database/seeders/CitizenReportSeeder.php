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

        $scenarios = [
            'flood' => [
                'Air sungai meluap menggenangi jalan raya hingga 30cm.',
                'Banjir bandang menerjang perumahan warga di bantaran sungai.',
                'Curah hujan tinggi menyebabkan air meluap ke pemukiman.',
            ],
            'drought' => [
                'Kekeringan parah membuat sumur warga mulai surut.',
                'Cuaca sangat panas, rawan terjadi kebakaran lahan gambut.',
                'Lahan pertanian warga retak-retak akibat kemarau panjang.',
            ],
            'strong_wind' => [
                'Pohon tumbang menghalangi lalu lintas utama.',
                'Angin kencang merusak beberapa atap rumah warga.',
                'Angin puting beliung terpantau di daerah pesisir pantai.',
            ],
            'other' => [
                'Hujan sangat deras disertai petir, jarak pandang terbatas.',
                'Kabut tebal menyelimuti wilayah ini, jarak pandang di bawah 10 meter.',
                'Cuaca mendung gelap disertai angin kencang berdurasi pendek.',
            ],
        ];

        $records = [];
        for ($i = 0; $i < 50; $i++) {
            $type = Arr::random(array_keys($scenarios));
            $records[] = [
                'anomaly_type' => $type,
                'location' => Arr::random($locations),
                'description' => Arr::random($scenarios[$type]),
                'created_at' => Carbon::now()->subDays(rand(0, 5))->subMinutes(rand(1, 1440)),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach (array_chunk($records, 100) as $chunk) {
            CitizenReport::insert($chunk);
        }
    }
}
