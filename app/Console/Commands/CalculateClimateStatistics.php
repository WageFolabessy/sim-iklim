<?php

namespace App\Console\Commands;

use App\Models\ClimateRecord;
use App\Services\HoltWintersService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        $tempAvg = (float) ($query->avg('temperature') ?? 0);
        $tempMin = (float) ($query->min('temperature') ?? 0);
        $tempMax = (float) ($query->max('temperature') ?? 0);
        $tempStddev = (float) ClimateRecord::where('status', 'published')->select(DB::raw('COALESCE(ROUND(STDDEV(temperature), 1), 0) as v'))->value('v');

        $humidityAvg = (float) ($query->avg('humidity') ?? 0);
        $humidityMin = (float) ($query->min('humidity') ?? 0);
        $humidityMax = (float) ($query->max('humidity') ?? 0);
        $humidityStddev = (float) ClimateRecord::where('status', 'published')->select(DB::raw('COALESCE(ROUND(STDDEV(humidity), 1), 0) as v'))->value('v');

        $rainfallAvg = (float) ($query->avg('rainfall') ?? 0);
        $rainfallMin = (float) ($query->min('rainfall') ?? 0);
        $rainfallMax = (float) ($query->max('rainfall') ?? 0);
        $rainfallStddev = (float) ClimateRecord::where('status', 'published')->select(DB::raw('COALESCE(ROUND(STDDEV(rainfall), 1), 0) as v'))->value('v');

        $windAvg = (float) ($query->avg('wind_speed') ?? 0);
        $windMin = (float) ($query->min('wind_speed') ?? 0);
        $windMax = (float) ($query->max('wind_speed') ?? 0);
        $windStddev = (float) ClimateRecord::where('status', 'published')->select(DB::raw('COALESCE(ROUND(STDDEV(wind_speed), 1), 0) as v'))->value('v');

        $monthlyRainfall = ClimateRecord::where('status', 'published')
            ->selectRaw('MONTH(recorded_at) as month, AVG(rainfall) as avg_rain')
            ->groupBy('month')
            ->pluck('avg_rain', 'month')
            ->toArray();

        $rainData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rainData[] = round($monthlyRainfall[$i] ?? 0, 1);
        }

        // --- Holt-Winters Forecasting ---
        // Fetch chronological data for Holt-Winters (requires actual time-series without gaps)
        $records = ClimateRecord::where('status', 'published')
            ->selectRaw('YEAR(recorded_at) as year, MONTH(recorded_at) as month, AVG(rainfall) as avg_rain')
            ->groupBy('year', 'month')
            ->get();

        $minDate = $query->min('recorded_at');
        $maxDate = $query->max('recorded_at');

        $historicalTimeSeries = [];
        $forecastMonths = [];

        if ($minDate && $maxDate) {
            $start = Carbon::parse($minDate)->startOfMonth();
            $end = Carbon::parse($maxDate)->startOfMonth();

            $rainfallDict = [];
            foreach ($records as $rec) {
                $rainfallDict[$rec->year.'-'.str_pad($rec->month, 2, '0', STR_PAD_LEFT)] = (float) $rec->avg_rain;
            }

            $current = $start->copy();
            while ($current->lte($end)) {
                $key = $current->format('Y-m');
                // Isi bulan yang kosong dengan 0 agar sequence periodik tidak rusak
                $historicalTimeSeries[] = $rainfallDict[$key] ?? 0.0;
                $current->addMonth();
            }

            // Determine the names of the forecasted months based on real chronological end date
            for ($i = 1; $i <= 3; $i++) {
                $next = $end->copy()->addMonths($i);
                $forecastMonths[] = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][$next->month - 1].' (Prediksi)';
            }
        } else {
            $forecastMonths = ['Bulan 1 (Prediksi)', 'Bulan 2 (Prediksi)', 'Bulan 3 (Prediksi)'];
        }

        $holtWinters = new HoltWintersService;
        // Predict for the next 3 months
        $forecastRainData = $holtWinters->forecast($historicalTimeSeries, 12, 3);

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
            'tempAvg', 'tempMin', 'tempMax', 'tempStddev',
            'humidityAvg', 'humidityMin', 'humidityMax', 'humidityStddev',
            'rainfallAvg', 'rainfallMin', 'rainfallMax', 'rainfallStddev',
            'windAvg', 'windMin', 'windMax', 'windStddev',
            'rainData', 'months', 'yearSpan', 'forecastRainData', 'forecastMonths'
        );

        Cache::put('climate_statistics', $dataArray, now()->addDays(1));

        $this->info('Climate statistics calculated and cached.');
    }
}
