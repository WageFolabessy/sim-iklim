<?php

use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\WeatherAlertNotification;
use Illuminate\Support\Facades\Notification;

// ---------------------------------------------------------------------------
// 1. Admin Alert Trigger Path
// ---------------------------------------------------------------------------

it('allows admin to trigger a weather alert, saves it, and dispatches notification', function (): void {
    Notification::fake();

    // Create a subscriber user and seed a push subscription so they are
    // returned by User::has('pushSubscriptions')->get() in the controller.
    $subscriber = User::factory()->create();
    DB::table('push_subscriptions')->insert([
        'subscribable_type' => User::class,
        'subscribable_id' => $subscriber->id,
        'endpoint' => 'https://fcm.googleapis.com/test-endpoint-'.$subscriber->id,
        'public_key' => null,
        'auth_token' => null,
        'content_encoding' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->post(route('admin.weather-alerts.trigger'), [
            'level' => 'awas',
            'title' => 'Banjir Besar Kalimantan Barat',
            'area' => 'Pontianak dan sekitarnya',
            'body' => 'Curah hujan ekstrem diprediksi terjadi dalam 24 jam ke depan.',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('weather_alerts', [
        'level' => 'awas',
        'title' => 'Banjir Besar Kalimantan Barat',
    ]);

    Notification::assertSentTo($subscriber, WeatherAlertNotification::class);
});

// ---------------------------------------------------------------------------
// 2. Role Access Control Path
// ---------------------------------------------------------------------------

it('blocks pengamat from triggering weather alerts', function (): void {
    $pengamat = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($pengamat)
        ->post(route('admin.weather-alerts.trigger'), [
            'level' => 'waspada',
            'title' => 'Uji Coba',
            'area' => 'Test',
            'body' => 'Ini seharusnya diblokir.',
        ])
        ->assertForbidden();
});
