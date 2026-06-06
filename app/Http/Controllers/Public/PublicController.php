<?php

namespace App\Http\Controllers\Public;

use App\Events\CitizenReportSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCitizenReportRequest;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use App\Models\User;
use App\Models\WeatherAlert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
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
        $stats = Cache::get('climate_statistics');

        if (! $stats) {
            Artisan::call('climate:calculate-stats');
            $stats = Cache::get('climate_statistics');
        }

        return view('public.statistics', $stats);
    }

    public function storeCitizenReport(StoreCitizenReportRequest $request): RedirectResponse
    {
        $report = CitizenReport::create($request->validated());

        CitizenReportSubmitted::dispatch($report);

        return back()->with('success', 'Laporan Anda berhasil dikirim. Terima kasih.');
    }

    public function subscribePush(Request $request): JsonResponse
    {
        $endpoint = $request->input('endpoint');
        $email = hash('sha256', $endpoint).'@device.local';

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Device Visitor', 'password' => bcrypt(Str::random(16))]
        );

        $user->updatePushSubscription(
            $endpoint,
            $request->input('keys.p256dh'),
            $request->input('keys.auth')
        );

        return response()->json(['success' => true]);
    }
}
