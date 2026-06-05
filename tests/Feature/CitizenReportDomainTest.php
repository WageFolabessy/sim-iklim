<?php

use App\Enums\AnomalyType;
use App\Enums\ReportStatus;
use App\Enums\UserRole;
use App\Models\CitizenReport;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Public Submission Path
// ---------------------------------------------------------------------------

it('allows public to submit a citizen report and defaults to pending', function (): void {
    $response = $this->post(route('citizen-reports.store'), [
        'reporter_name' => 'Budi Santoso',
        'location' => 'Pontianak, Kalimantan Barat',
        'anomaly_type' => AnomalyType::Flood->value,
        'description' => 'Banjir setinggi 50cm merendam jalan utama sejak pukul 03.00 WIB.',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $this->assertDatabaseHas('citizen_reports', [
        'location' => 'Pontianak, Kalimantan Barat',
        'anomaly_type' => AnomalyType::Flood->value,
        'status' => ReportStatus::Pending->value,
    ]);
});

// ---------------------------------------------------------------------------
// 2. Admin Moderation Path
// ---------------------------------------------------------------------------

it('allows admin to update the status of a citizen report', function (): void {
    $report = CitizenReport::factory()->create(['status' => ReportStatus::Pending->value]);
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->patch(route('admin.citizen-reports.update-status', $report), [
            'status' => ReportStatus::Published->value,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('citizen_reports', [
        'id' => $report->id,
        'status' => ReportStatus::Published->value,
    ]);
});
