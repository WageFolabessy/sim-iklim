<?php

use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Push Subscription Paths
// ---------------------------------------------------------------------------

it('allows public to subscribe to push notifications', function (): void {
    $response = $this->withSession(['_token' => 'test-token'])
        ->post(route('push.subscribe'), [
            '_token' => 'test-token',
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint-123',
            'public_key' => 'test-public-key',
            'auth_token' => 'test-auth-token',
            'content_encoding' => 'aes128gcm',
        ]);

    $response->assertSuccessful();
    $this->assertDatabaseHas('push_subscriptions', [
        'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint-123',
    ]);
});

it('allows public to unsubscribe from push notifications', function (): void {
    $endpoint = 'https://fcm.googleapis.com/fcm/send/test-unsubscribe';

    // Use a fake user for subscribable polymorphic relation
    $user = User::factory()->create();

    DB::table('push_subscriptions')->insert([
        'subscribable_type' => User::class,
        'subscribable_id' => $user->id,
        'endpoint' => $endpoint,
        'public_key' => 'key',
        'auth_token' => 'token',
        'content_encoding' => 'aes128gcm',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->withSession(['_token' => 'test-token'])
        ->delete(route('push.unsubscribe'), [
            '_token' => 'test-token',
            'endpoint' => $endpoint,
        ]);

    $response->assertSuccessful();
    $this->assertDatabaseMissing('push_subscriptions', [
        'endpoint' => $endpoint,
    ]);
});

// ---------------------------------------------------------------------------
// 2. Offline Page Path
// ---------------------------------------------------------------------------

it('renders the offline page successfully', function (): void {
    $this->get(route('offline'))->assertOk();
});
