<?php

namespace App\Http\Controllers\Public;

use App\Events\CitizenReportSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCitizenReportRequest;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        $latestRecord = ClimateRecord::latest('recorded_at')->first();

        return view('public.home', compact('latestRecord'));
    }

    public function climateData(): View
    {
        $records = ClimateRecord::with('user')
            ->latest('recorded_at')
            ->paginate(15);

        /**
         * Historical statistics for the current calendar month across the last 5 years.
         * Uses pure MySQL aggregations — no ML, no external dependencies.
         *
         * @var object{
         *   avg_temperature: float|null,
         *   min_temperature: float|null,
         *   max_temperature: float|null,
         *   stddev_temperature: float|null,
         *   avg_humidity: float|null,
         *   min_humidity: float|null,
         *   max_humidity: float|null,
         *   stddev_humidity: float|null,
         *   avg_rainfall: float|null,
         *   min_rainfall: float|null,
         *   max_rainfall: float|null,
         *   stddev_rainfall: float|null,
         * } $stats
         */
        $stats = ClimateRecord::query()
            ->whereMonth('recorded_at', now()->month)
            ->where('recorded_at', '>=', now()->subYears(5)->startOfMonth())
            ->select([
                DB::raw('AVG(temperature)   AS avg_temperature'),
                DB::raw('MIN(temperature)   AS min_temperature'),
                DB::raw('MAX(temperature)   AS max_temperature'),
                DB::raw('STDDEV(temperature) AS stddev_temperature'),
                DB::raw('AVG(humidity)      AS avg_humidity'),
                DB::raw('MIN(humidity)      AS min_humidity'),
                DB::raw('MAX(humidity)      AS max_humidity'),
                DB::raw('STDDEV(humidity)   AS stddev_humidity'),
                DB::raw('AVG(rainfall)      AS avg_rainfall'),
                DB::raw('MIN(rainfall)      AS min_rainfall'),
                DB::raw('MAX(rainfall)      AS max_rainfall'),
                DB::raw('STDDEV(rainfall)   AS stddev_rainfall'),
            ])
            ->first();

        return view('public.climate-data', compact('records', 'stats'));
    }

    public function storeCitizenReport(StoreCitizenReportRequest $request): RedirectResponse
    {
        $report = CitizenReport::create($request->validated());

        CitizenReportSubmitted::dispatch($report);

        return back()->with('success', 'Laporan Anda berhasil dikirim. Terima kasih.');
    }
}
