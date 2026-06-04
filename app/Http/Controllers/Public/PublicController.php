<?php

namespace App\Http\Controllers\Public;

use App\Events\CitizenReportSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCitizenReportRequest;
use App\Models\CitizenReport;
use App\Models\ClimateRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        return view('public.home');
    }

    public function climateData(): View
    {
        $records = ClimateRecord::with('user')
            ->latest('recorded_at')
            ->paginate(15);

        return view('public.climate-data', compact('records'));
    }

    public function storeCitizenReport(StoreCitizenReportRequest $request): RedirectResponse
    {
        $report = CitizenReport::create($request->validated());

        CitizenReportSubmitted::dispatch($report);

        return back()->with('success', 'Laporan Anda berhasil dikirim. Terima kasih.');
    }
}
