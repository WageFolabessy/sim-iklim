<?php

use App\Enums\UserRole;
use App\Models\ClimateRecord;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

// ---------------------------------------------------------------------------
// 1. Pengamat List Own Records
// ---------------------------------------------------------------------------

it('allows pengamat to view their own climate records', function (): void {
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);
    $otherPengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    ClimateRecord::factory()->count(3)->create(['user_id' => $pengamat->id]);
    ClimateRecord::factory()->count(2)->create(['user_id' => $otherPengamat->id]);

    $response = $this->actingAs($pengamat)
        ->get(route('pengamat.climate-records.index'));

    $response->assertOk();
    $response->assertViewHas('records', fn ($records) => $records->count() === 3);
});

it('paginates pengamat climate records', function (): void {
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    ClimateRecord::factory()->count(20)->create(['user_id' => $pengamat->id]);

    $response = $this->actingAs($pengamat)
        ->get(route('pengamat.climate-records.index'));

    $response->assertOk();
    $response->assertViewHas('records', fn ($records) => $records instanceof LengthAwarePaginator);
});
