<?php

use App\Enums\UserRole;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Climate Record Validation Edge Cases
// ---------------------------------------------------------------------------

it('accepts climate data with negative temperature', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->post(route('pengamat.climate-records.store'), [
            'recorded_at' => '2026-06-05',
            'temperature' => -10,
            'humidity' => 85,
            'rainfall' => 12.3,
            'wind_speed' => 7.2,
        ])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('climate_records', ['temperature' => -10]);
});

it('accepts climate data with humidity over 100', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->post(route('pengamat.climate-records.store'), [
            'recorded_at' => '2026-06-05',
            'temperature' => 31.5,
            'humidity' => 150,
            'rainfall' => 12.3,
            'wind_speed' => 7.2,
        ])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('climate_records', ['humidity' => 150]);
});

it('rejects climate data with non-numeric temperature', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->post(route('pengamat.climate-records.store'), [
            'recorded_at' => '2026-06-05',
            'temperature' => 'panas',
            'humidity' => 85,
            'rainfall' => 12.3,
            'wind_speed' => 7.2,
        ])
        ->assertSessionHasErrors('temperature');
});

// ---------------------------------------------------------------------------
// 2. Citizen Report Validation Edge Cases
// ---------------------------------------------------------------------------

it('rejects citizen report with empty description', function (): void {
    $this->post(route('citizen-reports.store'), [
        'reporter_name' => 'Budi',
        'location' => 'Pontianak',
        'anomaly_type' => 'flood',
        'description' => '',
    ])
        ->assertSessionHasErrors('description');
});

it('rejects citizen report with invalid anomaly type', function (): void {
    $this->post(route('citizen-reports.store'), [
        'reporter_name' => 'Budi',
        'location' => 'Pontianak',
        'anomaly_type' => 'invalid_type',
        'description' => 'Test description',
    ])
        ->assertSessionHasErrors('anomaly_type');
});

// ---------------------------------------------------------------------------
// 3. Weather Alert Validation Edge Cases
// ---------------------------------------------------------------------------

it('rejects weather alert with invalid level', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->post(route('admin.weather-alerts.trigger'), [
            'level' => 'panik',
            'title' => 'Test Alert',
            'area' => 'Pontianak',
            'body' => 'Test body',
        ])
        ->assertSessionHasErrors('level');
});
