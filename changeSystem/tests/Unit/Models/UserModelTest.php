<?php

use App\Models\Device;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;

test('user has many devices', function () {
    $user = User::factory()->create();
    $devices = Device::factory()->count(3)->for($user)->create();

    expect($user->devices()->count())->toBe(3);
    expect($user->devices)->toHaveCount(3);
});

test('user has many orders', function () {
    $user = User::factory()->create();
    $orders = Order::factory()->count(5)->for($user)->create();

    expect($user->orders()->count())->toBe(5);
});

test('user has many transactions', function () {
    $user = User::factory()->create();
    $transactions = Transaction::factory()->count(4)->for($user)->create();

    expect($user->transactions()->count())->toBe(4);
});

test('user initials are generated correctly', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    expect($user->initials())->toBe('JD');
});

test('user initials with single name', function () {
    $user = User::factory()->create(['name' => 'Madonna']);

    expect($user->initials())->toBe('M');
});

test('user initials with multiple spaces', function () {
    $user = User::factory()->create(['name' => 'Jean Claude Van Damme']);

    expect($user->initials())->toBe('JC');
});

test('user active status check', function () {
    $user = User::factory()->create(['status' => 'active']);

    expect($user->active())->toBeTrue();
});

test('user banned status check', function () {
    $user = User::factory()->create(['status' => 'banned']);

    expect($user->banned())->toBeTrue();
});

test('user can be marked as active', function () {
    $user = User::factory()->create(['status' => 'inactive']);

    $user->markAsActive();

    expect($user->status->value)->toBe('active');
});

test('user can be marked as inactive', function () {
    $user = User::factory()->create(['status' => 'active']);

    $user->markAsInactive();

    expect($user->status->value)->toBe('inactive');
});

test('user can be marked as banned', function () {
    $user = User::factory()->create(['status' => 'active']);

    $user->markAsBanned();

    expect($user->status->value)->toBe('banned');
});

test('user has balance attribute', function () {
    $user = User::factory()->create(['balance' => 1000]);

    expect($user->balance)->toBe(1000);
});

test('user has two factor authentication attributes', function () {
    $user = User::factory()->withTwoFactor()->create();

    expect($user->two_factor_secret)->not->toBeNull();
    expect($user->two_factor_recovery_codes)->not->toBeNull();
    expect($user->two_factor_confirmed_at)->not->toBeNull();
});

test('user uses ulid for id', function () {
    $user = User::factory()->create();

    expect($user->id)->toBeTruthy();
    expect(strlen($user->id))->toBe(26);
});
