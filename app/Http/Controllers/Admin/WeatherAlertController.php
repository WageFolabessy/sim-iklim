<?php

namespace App\Http\Controllers\Admin;

use App\Events\WeatherAlertBroadcasted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TriggerWeatherAlertRequest;
use App\Models\User;
use App\Models\WeatherAlert;
use App\Notifications\WeatherAlertNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

class WeatherAlertController extends Controller
{
    public function trigger(TriggerWeatherAlertRequest $request): RedirectResponse
    {
        $alert = WeatherAlert::create($request->validated());

        WeatherAlertBroadcasted::dispatch($alert);

        Notification::send(
            User::has('pushSubscriptions')->get(),
            new WeatherAlertNotification($alert)
        );

        return back()->with('success', 'Peringatan cuaca berhasil disiarkan.');
    }
}
