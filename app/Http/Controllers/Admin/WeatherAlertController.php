<?php

namespace App\Http\Controllers\Admin;

use App\Events\WeatherAlertBroadcasted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TriggerWeatherAlertRequest;
use Illuminate\Http\RedirectResponse;

class WeatherAlertController extends Controller
{
    public function trigger(TriggerWeatherAlertRequest $request): RedirectResponse
    {
        WeatherAlertBroadcasted::dispatch($request->validated('message'));

        return back()->with('success', 'Peringatan cuaca berhasil disiarkan.');
    }
}
