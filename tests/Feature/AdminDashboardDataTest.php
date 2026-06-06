<?php

use App\Enums\UserRole;
use App\Models\ClimateRecord;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

// ---------------------------------------------------------------------------
// 1. Admin Dashboard Data
// ---------------------------------------------------------------------------

it('shows pending climate records on admin dashboard', function (): void {
    ClimateRecord::factory()->count(5)->create(['status' => 'pending']);
    ClimateRecord::factory()->count(3)->create(['status' => 'published']);

    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendingRecords', fn ($records) => $records->total() === 5);
});

it('paginates pending climate records on admin dashboard', function (): void {
    ClimateRecord::factory()->count(15)->create(['status' => 'pending']);

    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendingRecords', fn ($records) => $records instanceof LengthAwarePaginator);
});
