<?php

use App\Enums\AnomalyType;
use App\Events\CitizenReportSubmitted;
use App\Events\WeatherAlertBroadcasted;
use App\Models\CitizenReport;
use App\Models\WeatherAlert;
use Illuminate\Support\Facades\Event;

// ---------------------------------------------------------------------------
// 1. Event Broadcasting
// ---------------------------------------------------------------------------

it('dispatches CitizenReportSubmitted event when public submits report', function (): void {
    Event::fake();

    $this->post(route('citizen-reports.store'), [
        'reporter_name' => 'Budi Santoso',
        'location' => 'Pontianak',
        'anomaly_type' => AnomalyType::Flood->value,
        'description' => 'Banjir di Pontianak',
    ]);

    Event::assertDispatched(CitizenReportSubmitted::class);
});

it('WeatherAlertBroadcasted event contains alert data', function (): void {
    $alert = WeatherAlert::factory()->create([
        'level' => 'awas',
        'title' => 'Test Alert',
    ]);

    $event = new WeatherAlertBroadcasted($alert);

    expect($event->alert->level)->toBe('awas')
        ->and($event->alert->title)->toBe('Test Alert');
});

it('CitizenReportSubmitted event contains report data', function (): void {
    $report = CitizenReport::factory()->create([
        'location' => 'Pontianak',
        'anomaly_type' => AnomalyType::Flood,
    ]);

    $event = new CitizenReportSubmitted($report);

    expect($event->citizenReport->location)->toBe('Pontianak')
        ->and($event->citizenReport->anomaly_type)->toBe(AnomalyType::Flood);
});
