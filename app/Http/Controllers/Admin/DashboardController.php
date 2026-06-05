<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use App\Models\WeatherAlert;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeAlerts = WeatherAlert::count();
        $citizenReports = CitizenReport::count();
        $climateRecords = ClimateRecord::count();

        $pendingRecords = ClimateRecord::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('activeAlerts', 'citizenReports', 'climateRecords', 'pendingRecords'));
    }
}
