<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCitizenReportStatusRequest;
use App\Models\CitizenReport;
use App\Models\User;
use App\Notifications\CitizenReportPublishedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class CitizenReportController extends Controller
{
    public function index(): View
    {
        $reports = CitizenReport::latest()->paginate(15);

        return view('admin.citizen-reports.index', compact('reports'));
    }

    public function updateStatus(CitizenReport $report, UpdateCitizenReportStatusRequest $request): RedirectResponse
    {
        $report->update($request->validated());

        if ($report->status === ReportStatus::Published) {
            Notification::send(
                User::has('pushSubscriptions')->get(),
                new CitizenReportPublishedNotification($report)
            );
        }

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
