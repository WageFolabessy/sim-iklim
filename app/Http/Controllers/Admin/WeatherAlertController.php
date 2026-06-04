<?php

namespace App\Http\Controllers\Admin;

use App\Events\WeatherAlertBroadcasted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TriggerWeatherAlertRequest;
use App\Models\WeatherAlert;
use Illuminate\Http\RedirectResponse;

class WeatherAlertController extends Controller
{
    public function trigger(TriggerWeatherAlertRequest $request): RedirectResponse
    {
        $alert = WeatherAlert::create($request->validated());

        WeatherAlertBroadcasted::dispatch($alert);

        return back()->with('success', 'Peringatan cuaca berhasil disiarkan.');
    }
}
