<?php

namespace App\Http\Controllers\Public;

use App\Events\CitizenReportSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCitizenReportRequest;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use App\Models\WeatherAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        $latestRecord = ClimateRecord::latest('recorded_at')->first();
        $activeAlerts = WeatherAlert::latest()->take(3)->get();
        $recentReports = CitizenReport::latest()->take(5)->get();

        return view('public.home', compact('latestRecord', 'activeAlerts', 'recentReports'));
    }

    public function report(): View
    {
        return view('public.report');
    }

    public function alerts(): View
    {
        $alerts = WeatherAlert::latest()->get();

        return view('public.alerts', compact('alerts'));
    }

    public function statistics(): View
    {
        $tempAvg = ClimateRecord::avg('temperature') ?? 0;
        $tempMin = ClimateRecord::min('temperature') ?? 0;
        $tempMax = ClimateRecord::max('temperature') ?? 0;

        $humidityAvg = ClimateRecord::avg('humidity') ?? 0;
        $humidityMin = ClimateRecord::min('humidity') ?? 0;
        $humidityMax = ClimateRecord::max('humidity') ?? 0;

        $rainfallAvg = ClimateRecord::avg('rainfall') ?? 0;
        $rainfallMin = ClimateRecord::min('rainfall') ?? 0;
        $rainfallMax = ClimateRecord::max('rainfall') ?? 0;

        $windAvg = ClimateRecord::avg('wind_speed') ?? 0;
        $windMin = ClimateRecord::min('wind_speed') ?? 0;
        $windMax = ClimateRecord::max('wind_speed') ?? 0;

        $monthlyRainfall = ClimateRecord::selectRaw('MONTH(recorded_at) as month, AVG(rainfall) as avg_rain')
            ->groupBy('month')
            ->pluck('avg_rain', 'month');

        $rainData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rainData[] = round($monthlyRainfall[$i] ?? 0, 1);
        }

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return view('public.statistics', compact(
            'tempAvg', 'tempMin', 'tempMax',
            'humidityAvg', 'humidityMin', 'humidityMax',
            'rainfallAvg', 'rainfallMin', 'rainfallMax',
            'windAvg', 'windMin', 'windMax',
            'rainData', 'months'
        ));
    }

    public function storeCitizenReport(StoreCitizenReportRequest $request): RedirectResponse
    {
        $report = CitizenReport::create($request->validated());

        CitizenReportSubmitted::dispatch($report);

        return back()->with('success', 'Laporan Anda berhasil dikirim. Terima kasih.');
    }
}
