<?php

namespace App\Http\Controllers\Admin;

use App\Events\ClimateDataPublished;
use App\Http\Controllers\Controller;
use App\Models\ClimateRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClimateRecordValidationController extends Controller
{
    public function approve(Request $request, $id): RedirectResponse
    {
        $climateRecord = ClimateRecord::findOrFail($id);

        $climateRecord->status = 'published';
        $climateRecord->save();

        event(new ClimateDataPublished($climateRecord));

        return back()->with('success', 'Data iklim berhasil divalidasi dan dipublikasikan.');
    }
}
