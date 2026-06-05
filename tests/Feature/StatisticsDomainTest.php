<?php

use App\Models\ClimateRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

// ---------------------------------------------------------------------------
// 1. Scheduler / Command Path
// ---------------------------------------------------------------------------

it('calculates and caches historical climate statistics', function (): void {
    Cache::forget('climate_statistics');

    ClimateRecord::factory()->count(3)->create(['status' => 'published']);

    Artisan::call('climate:calculate-stats');

    expect(Cache::has('climate_statistics'))->toBeTrue();
});

// ---------------------------------------------------------------------------
// 2. Public Fallback Path
// ---------------------------------------------------------------------------

it('returns the public statistics view and handles cache generation', function (): void {
    Cache::forget('climate_statistics');

    $response = $this->get('/statistik');

    $response->assertStatus(200);
    $response->assertViewIs('public.statistics');
});
