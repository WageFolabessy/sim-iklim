<?php

namespace App\Console\Commands;

use App\Models\ClimateRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CalculateClimateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'climate:calculate-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and cache historical climate statistics';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = ClimateRecord::where('status', 'published');

        $tempAvg = $query->avg('temperature') ?? 0;
        $tempMin = $query->min('temperature') ?? 0;
        $tempMax = $query->max('temperature') ?? 0;

        $humidityAvg = $query->avg('humidity') ?? 0;
        $humidityMin = $query->min('humidity') ?? 0;
        $humidityMax = $query->max('humidity') ?? 0;

        $rainfallAvg = $query->avg('rainfall') ?? 0;
        $rainfallMin = $query->min('rainfall') ?? 0;
        $rainfallMax = $query->max('rainfall') ?? 0;

        $windAvg = $query->avg('wind_speed') ?? 0;
        $windMin = $query->min('wind_speed') ?? 0;
        $windMax = $query->max('wind_speed') ?? 0;

        $monthlyRainfall = ClimateRecord::where('status', 'published')
            ->selectRaw('MONTH(recorded_at) as month, AVG(rainfall) as avg_rain')
            ->groupBy('month')
            ->pluck('avg_rain', 'month')
            ->toArray();

        $rainData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rainData[] = round($monthlyRainfall[$i] ?? 0, 1);
        }

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $minDate = $query->min('recorded_at');
        $maxDate = $query->max('recorded_at');
        if ($minDate && $maxDate) {
            $minYear = date('Y', strtotime($minDate));
            $maxYear = date('Y', strtotime($maxDate));
            $yearSpan = $minYear === $maxYear ? "Data tahun {$minYear}" : "Data tahun {$minYear} - {$maxYear}";
        } else {
            $yearSpan = 'Belum ada data';
        }

        $dataArray = compact(
            'tempAvg', 'tempMin', 'tempMax',
            'humidityAvg', 'humidityMin', 'humidityMax',
            'rainfallAvg', 'rainfallMin', 'rainfallMax',
            'windAvg', 'windMin', 'windMax',
            'rainData', 'months', 'yearSpan'
        );

        Cache::put('climate_statistics', $dataArray, now()->addHours(24));

        $this->info('Climate statistics calculated and cached.');
    }
}
