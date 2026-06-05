<?php

namespace App\Listeners;

use App\Events\ClimateDataPublished;
use Illuminate\Support\Facades\Artisan;

class RecalculateStatisticsCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClimateDataPublished $event): void
    {
        Artisan::call('climate:calculate-stats');
    }
}
