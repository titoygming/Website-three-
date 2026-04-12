<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Device;
use App\Models\Service;
use Livewire\Livewire;
use App\Enums\OrderStatus;

it('renders successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('manager.orders')
        ->assertStatus(200);
});

it('displays all orders with pagination', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Order::factory()->count(15)->create();

    $component = Livewire::test('manager.orders');
    $component->assertStatus(200);
    $component->assertViewHas('orders');
});

it('accepts an order', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);

    $component = Livewire::test('manager.orders');
    $component->call('accept', $order->id);

    $order->refresh();
    expect($order->status->value)->toBe(OrderStatus::ACCEPTED->value);
});

it('rejects an order', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);
    $originalBalance = $order->user->balance;

    $component = Livewire::test('manager.orders');
    $component->call('reject', $order->id);

    $order->refresh();
    expect($order->status->value)->toBe(OrderStatus::REJECTED->value);
    
    $order->user->refresh();
    expect($order->user->balance)->toBeGreaterThan($originalBalance);
});

it('marks order as done', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $order = Order::factory()->create(['status' => OrderStatus::ACCEPTED->value]);

    $component = Livewire::test('manager.orders');
    $component->call('done', $order->id);

    $order->refresh();
    expect($order->status->value)->toBe(OrderStatus::DONE->value);
});

it('cancels an order', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $order = Order::factory()->create(['status' => OrderStatus::PENDING->value]);
    $originalBalance = $order->user->balance;

    $component = Livewire::test('manager.orders');
    $component->call('cancel', $order->id);

    $order->refresh();
    expect($order->status->value)->toBe(OrderStatus::CANCELED->value);
    
    $order->user->refresh();
    expect($order->user->balance)->toBeGreaterThan($originalBalance);
});

it('searches orders by device imei', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $device1 = Device::factory()->create(['imei' => '1111111111111']);
    $device2 = Device::factory()->create(['imei' => '2222222222222']);

    Order::factory()->for($device1)->create();
    Order::factory()->for($device2)->create();

    $component = Livewire::test('manager.orders')
        ->set('search', '111111111');

    $component->assertStatus(200);
});

it('paginates orders', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Order::factory()->count(25)->create();

    $component = Livewire::test('manager.orders')
        ->set('quantity', 10);

    expect($component->viewData('orders'))->toHaveCount(10);
});
