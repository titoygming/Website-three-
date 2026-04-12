<?php

use App\Models\Device;
use App\Models\Order;
use App\Models\User;

test('device belongs to user', function () {
    $user = User::factory()->create();
    $device = Device::factory()->for($user)->create();

    expect($device->user)->toBeInstanceOf(User::class);
    expect($device->user->id)->toBe($user->id);
});

test('device has many orders', function () {
    $device = Device::factory()->create();
    Order::factory()->count(3)->for($device)->create();

    expect($device->orders()->count())->toBe(3);
});

test('device stores imei', function () {
    $imei = '123456789012345';
    $device = Device::factory()->create(['imei' => $imei]);

    expect($device->imei)->toBe($imei);
});

test('device stores model name', function () {
    $model = 'iPhone 14 Pro';
    $device = Device::factory()->create(['model' => $model]);

    expect($device->model)->toBe($model);
});

test('device uses ulid for id', function () {
    $device = Device::factory()->create();

    expect($device->id)->toBeTruthy();
    expect(strlen($device->id))->toBe(26);
});

test('device belongs to specific user only', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $device1 = Device::factory()->for($user1)->create();
    $device2 = Device::factory()->for($user2)->create();

    expect($device1->user_id)->toBe($user1->id);
    expect($device2->user_id)->toBe($user2->id);
    expect($device1->user_id)->not->toBe($user2->id);
});

test('device timestamps are stored', function () {
    $device = Device::factory()->create();

    expect($device->created_at)->not->toBeNull();
    expect($device->updated_at)->not->toBeNull();
});
