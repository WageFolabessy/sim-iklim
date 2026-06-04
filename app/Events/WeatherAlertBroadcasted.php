<?php

namespace App\Events;

use App\Models\WeatherAlert;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WeatherAlertBroadcasted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly WeatherAlert $alert) {}

    public function broadcastOn(): Channel
    {
        return new Channel('weather-alerts');
    }
}
