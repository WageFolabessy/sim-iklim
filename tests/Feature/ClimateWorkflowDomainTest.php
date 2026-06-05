<?php

use App\Enums\UserRole;
use App\Events\ClimateDataPublished;
use App\Models\ClimateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Event;

// ---------------------------------------------------------------------------
// 1. Submission Paths — Pengamat
// ---------------------------------------------------------------------------

it('allows pengamat to submit climate data and sets status to pending', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->post(route('pengamat.climate-records.store'), [
            'recorded_at' => '2026-06-05',
            'temperature' => 31.5,
            'humidity' => 85,
            'rainfall' => 12.3,
            'wind_speed' => 7.2,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('climate_records', [
        'user_id' => $user->id,
        'status' => 'pending',
    ]);
});

it('rejects climate data submission if wind_speed is missing', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->post(route('pengamat.climate-records.store'), [
            'recorded_at' => '2026-06-05',
            'temperature' => 31.5,
            'humidity' => 85,
            'rainfall' => 12.3,
            // wind_speed intentionally omitted
        ])
        ->assertSessionHasErrors('wind_speed');

    $this->assertDatabaseCount('climate_records', 0);
});

// ---------------------------------------------------------------------------
// 2. Validation Paths — Admin
// ---------------------------------------------------------------------------

it('allows admin to approve pending data and dispatches broadcast event', function (): void {
    Event::fake();

    $record = ClimateRecord::factory()->create(['status' => 'pending']);
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->patch(route('admin.climate-records.approve', $record->id))
        ->assertRedirect();

    $this->assertDatabaseHas('climate_records', [
        'id' => $record->id,
        'status' => 'published',
    ]);

    Event::assertDispatched(ClimateDataPublished::class);
});

it('blocks pengamat from approving climate data', function (): void {
    $record = ClimateRecord::factory()->create(['status' => 'pending']);
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($pengamat)
        ->patch(route('admin.climate-records.approve', $record->id))
        ->assertForbidden();
});
