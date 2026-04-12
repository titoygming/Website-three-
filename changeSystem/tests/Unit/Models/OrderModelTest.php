<?php

use App\Enums\OrderStatus;
use App\Models\Device;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;

test('order belongs to user', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create();

    expect($order->user)->toBeInstanceOf(User::class);
    expect($order->user->id)->toBe($user->id);
});

test('order belongs to device', function () {
    $device = Device::factory()->create();
    $order = Order::factory()->for($device)->create();

    expect($order->device)->toBeInstanceOf(Device::class);
    expect($order->device->id)->toBe($device->id);
});

test('order belongs to service', function () {
    $service = Service::factory()->create();
    $order = Order::factory()->create(['service_id' => $service->id]);

    expect($order->service)->toBeInstanceOf(Service::class);
    expect($order->service->id)->toBe($service->id);
});

test('order can be marked as accepted',function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);

    $order->markAsAccepted();

    expect($order->status)->toBe(OrderStatus::ACCEPTED);
});

test('order can be marked as rejected', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);

    $order->markAsRejected();

    expect($order->status)->toBe(OrderStatus::REJECTED);
});

test('order can be marked as done', function () {
    $order = Order::factory()->create(['status' => OrderStatus::ACCEPTED->value]);

    $order->markAsDone();

    expect($order->status)->toBe(OrderStatus::DONE);
});

test('order can be marked as cancelled', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);

    $order->markAsCancelled();

    expect($order->status)->toBe(OrderStatus::CANCELED);
});

test('order preserves amount', function () {
    $amount = 250.50;
    $order = Order::factory()->create(['amount' => $amount]);

    expect($order->amount)->toBe($amount);
});

test('order uses ulid for id', function () {
    $order = Order::factory()->create();

    expect($order->id)->toBeTruthy();
    expect(strlen($order->id))->toBe(26);
});

test('order has timestamps', function () {
    $order = Order::factory()->create();

    expect($order->created_at)->not->toBeNull();
    expect($order->updated_at)->not->toBeNull();
});
