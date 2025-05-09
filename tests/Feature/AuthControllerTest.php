<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

it('can register a user', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => 'student'
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'accessToken',
            'tokenType',
            'expiresAt',
            'user' => ['id', 'name', 'email', 'phone', 'role']
        ]);

    expect(User::where('email', 'test@example.com')->exists())->toBeTrue();
});

it('can login with email', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('Password123!')
    ]);

    $this->postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'Password123!'
    ])->assertOk()
      ->assertJsonStructure(['accessToken', 'tokenType', 'user']);
});

it('can login with phone', function () {
    User::factory()->create([
        'phone' => '1234567890',
        'password' => Hash::make('Password123!')
    ]);

    $this->postJson('/api/auth/login', [
        'phone' => '1234567890',
        'password' => 'Password123!'
    ])->assertOk();
});

it('fails login with invalid credentials', function () {
    $this->postJson('/api/auth/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword'
    ])->assertUnauthorized();
});

it('prevents banned users from logging in', function () {
    User::factory()->create([
        'email' => 'banned@example.com',
        'password' => Hash::make('Password123!'),
        'is_banned' => true
    ]);

    $this->postJson('/api/auth/login', [
        'email' => 'banned@example.com',
        'password' => 'Password123!'
    ])->assertForbidden();
});

it('can logout a user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/auth/logout')
        ->assertOk()
        ->assertJson(['message' => 'Logged out successfully']);

    expect($user->tokens)->toHaveCount(0);
});