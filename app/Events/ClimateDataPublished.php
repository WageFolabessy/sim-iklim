<?php

namespace App\Events;

use App\Models\ClimateRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClimateDataPublished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly ClimateRecord $climateRecord) {}

    public function broadcastOn(): Channel
    {
        return new Channel('climate-data');
    }
}
