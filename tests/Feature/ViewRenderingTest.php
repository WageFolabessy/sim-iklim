<?php

use App\Enums\UserRole;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Public Views
// ---------------------------------------------------------------------------

it('renders the public home page successfully', function (): void {
    $this->get('/')->assertOk();
});

it('renders the public alerts page successfully', function (): void {
    $this->get(route('peringatan'))->assertOk();
});

it('renders the public citizen report form successfully', function (): void {
    $this->get(route('laporkan'))->assertOk();
});

// ---------------------------------------------------------------------------
// 2. Admin Views
// ---------------------------------------------------------------------------

it('renders the admin dashboard successfully with required data', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertViewIs('admin.dashboard');
});

it('renders the admin citizen reports moderation page successfully', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get(route('admin.citizen-reports.index'))
        ->assertOk();
});

// ---------------------------------------------------------------------------
// 3. Pengamat Views
// ---------------------------------------------------------------------------

it('renders the pengamat input dashboard successfully', function (): void {
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($pengamat)
        ->get(route('pengamat.dashboard'))
        ->assertOk();
});
