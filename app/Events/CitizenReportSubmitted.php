<?php

namespace App\Events;

use App\Models\CitizenReport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CitizenReportSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly CitizenReport $citizenReport) {}

    public function broadcastOn(): Channel
    {
        return new Channel('citizen-reports');
    }
}
