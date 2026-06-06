<?php

use App\Enums\AnomalyType;
use App\Enums\ReportStatus;
use App\Enums\UserRole;
use App\Models\CitizenReport;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Admin Citizen Reports Filtering
// ---------------------------------------------------------------------------

it('filters citizen reports by status', function (): void {
    CitizenReport::factory()->count(3)->create(['status' => ReportStatus::Pending]);
    CitizenReport::factory()->count(2)->create(['status' => ReportStatus::Published]);

    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)
        ->get(route('admin.citizen-reports.index', ['status' => 'pending']));

    $response->assertOk();
    $response->assertViewHas('reports', fn ($reports) => $reports->count() === 3);
});

it('filters citizen reports by anomaly type', function (): void {
    CitizenReport::factory()->count(4)->create(['anomaly_type' => AnomalyType::Flood]);
    CitizenReport::factory()->count(2)->create(['anomaly_type' => AnomalyType::Drought]);

    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)
        ->get(route('admin.citizen-reports.index', ['anomaly' => 'flood']));

    $response->assertOk();
    $response->assertViewHas('reports', fn ($reports) => $reports->count() === 4);
});
