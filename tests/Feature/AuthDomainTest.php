<?php

use App\Enums\UserRole;
use App\Models\User;

// ---------------------------------------------------------------------------
// 1. Authentication Paths — Login
// ---------------------------------------------------------------------------

it('authenticates admin and redirects to admin dashboard', function (): void {
    $user = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('admin.dashboard'));
});

it('authenticates pengamat and redirects to pengamat dashboard', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('pengamat.dashboard'));
});

it('rejects login with incorrect password', function (): void {
    User::factory()->create(['email' => 'officer@bmkg.go.id']);

    $response = $this->post('/login', [
        'email' => 'officer@bmkg.go.id',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

it('rejects login with unregistered email', function (): void {
    $response = $this->post('/login', [
        'email' => 'ghost@nowhere.invalid',
        'password' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

// ---------------------------------------------------------------------------
// 2. Session Paths — Logout
// ---------------------------------------------------------------------------

it('logs out an authenticated user', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('home'));
});

// ---------------------------------------------------------------------------
// 3. Boundary & Access Control Paths — Middleware
// ---------------------------------------------------------------------------

it('blocks guests from accessing admin dashboard', function (): void {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('blocks guests from accessing pengamat dashboard', function (): void {
    $this->get(route('pengamat.dashboard'))
        ->assertRedirect(route('login'));
});

it('forbids pengamat from accessing admin routes', function (): void {
    $user = User::factory()->create(['role' => UserRole::Pengamat]);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('forbids admin from accessing pengamat routes', function (): void {
    $user = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($user)
        ->get(route('pengamat.dashboard'))
        ->assertForbidden();
});
