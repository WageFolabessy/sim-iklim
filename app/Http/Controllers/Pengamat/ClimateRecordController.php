<?php

namespace App\Http\Controllers\Pengamat;

use App\Events\ClimateDataPublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengamat\StoreClimateRecordRequest;
use App\Models\ClimateRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClimateRecordController extends Controller
{
    public function index(): View
    {
        $records = ClimateRecord::whereBelongsTo(auth()->user())
            ->latest('recorded_at')
            ->paginate(15);

        return view('pengamat.climate-records.index', compact('records'));
    }

    public function store(StoreClimateRecordRequest $request): RedirectResponse
    {
        $record = auth()->user()->climateRecords()->create($request->validated());

        ClimateDataPublished::dispatch($record);

        return back()->with('success', 'Data iklim berhasil disimpan.');
    }
}
