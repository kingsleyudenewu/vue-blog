<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
uses()->group('auth');

uses(WithFaker::class);


test('user can register into the system', function () {
    $user = persistUser();

    $payload = [
        'email' => $user->email,
        'name' => $user->name,
        'password' => 'password',
        'role' => User::ADMIN
    ];

    $this->json('POST', route('auth.register'), $payload)
        ->assertStatus(201)
        ->assertJsonFragment([
            'message' => 'User created successfully'
        ]);

    $user = User::latest()->first();
    expect($user->name)->toBeString()->not->toBeEmpty();
    expect($user->email)->toBeString()->toContain('@');
});

test('user can login into blog', function () {
    $user = createUser();

    $payload = [
        'email' => $user->email,
        'password' => 'password',
    ];

    $this->json('POST', route('auth.login'), $payload)
        ->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'User Logged In Successfully'
        ]);

    $this->isAuthenticated();
});

test('user must enter email address to login', function () {
    $payload = [
        'password' => 'password',
    ];

    $this->json('POST',route('auth.login'), $payload)
        ->assertStatus(422)
        ->assertJsonFragment([
            'message' => 'The email field is required.'
        ]);
});

test('user must enter password to login', function () {
    $user = createUser();

    $payload = [
        'email' => $user->email,
    ];

    $this->json('POST',route('auth.login'), $payload)
        ->assertStatus(422)
        ->assertJsonFragment([
            'message' => 'The password field is required.'
        ]);
});

test('user enter the wrong password to login', function () {
    $user = createUser();

    $payload = [
        'email' => $user->email,
        'password' => 'wrong_password'
    ];

    $this->json('POST',route('auth.login'), $payload)
        ->assertStatus(400)
        ->assertJsonFragment([
            'message' => 'Invalid login credentials',
            'status' => 'error'
        ]);
});
