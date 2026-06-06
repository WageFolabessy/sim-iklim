<?php

use App\Enums\UserRole;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Cross-Role Access Control
// ---------------------------------------------------------------------------

it('forbids pengamat from accessing admin citizen reports index', function (): void {
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($pengamat)
        ->get(route('admin.citizen-reports.index'))
        ->assertForbidden();
});

it('forbids admin from accessing pengamat climate records index', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get(route('pengamat.climate-records.index'))
        ->assertForbidden();
});
