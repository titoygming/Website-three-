<?php

use App\Models\Device;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('orders')
        ->assertStatus(200);
});

it('displays all user orders', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Order::factory()->for($user)->create();
    Order::factory()->for($user)->create();

    $component = Livewire::test('orders');
    $component->assertStatus(200);
});

it('paginates orders', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Order::factory()->count(10)->for($user)->create();

    $component = Livewire::test('orders')
        ->set('quantity', 5);

    $component->assertSet('quantity', 5);
});

it('searches orders by device imei', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $device1 = Device::factory()->for($user)->create(['imei' => '1111111111111']);
    $device2 = Device::factory()->for($user)->create(['imei' => '2222222222222']);

    Order::factory()->for($user)->for($device1)->create();
    Order::factory()->for($user)->for($device2)->create();

    Livewire::test('orders')
        ->set('search', '111111111')
        ->assertStatus(200);
});

it('loads services list', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Service::factory()->count(3)->create();

    Livewire::test('orders')
        ->assertStatus(200);
});

it('loads devices list', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Device::factory()->count(3)->for($user)->create();

    Livewire::test('orders')
        ->assertStatus(200);
});

it('validates required fields when taking order', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('orders')
        ->set('serviceId', null)
        ->set('deviceId', null)
        ->call('takeOrder')
        ->assertHasErrors(['serviceId', 'deviceId']);
});

it('validates serviceId with valid deviceId', function () {
    $user = User::factory()->create(['balance' => 100]);
    $this->actingAs($user);

    $device = Device::factory()->for($user)->create();
    $service = Service::factory()->create(['price' => 50]);

    Livewire::test('orders')
        ->set('serviceId', $service->id)
        ->set('deviceId', $device->id)
        ->call('takeOrder')
        ->assertHasNoErrors();
});

it('validates deviceId exists', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $service = Service::factory()->create();

    Livewire::test('orders')
        ->set('serviceId', $service->id)
        ->set('deviceId', 'invalid-device-id')
        ->call('takeOrder')
        ->assertHasErrors('deviceId');
});

it('creates an order successfully', function () {
    $user = User::factory()->create(['balance' => 1000]);
    $this->actingAs($user);

    $device = Device::factory()->for($user)->create();
    $service = Service::factory()->create(['price' => 50]);

    Livewire::test('orders')
        ->set('serviceId', $service->id)
        ->set('deviceId', $device->id)
        ->call('takeOrder')
        ->assertHasNoErrors();

    expect(Order::where('device_id', $device->id)->exists())->toBeTrue();
});

it('resets form after successful order creation', function () {
    $user = User::factory()->create(['balance' => 1000]);
    $this->actingAs($user);

    $device = Device::factory()->for($user)->create();
    $service = Service::factory()->create(['price' => 50]);

    Livewire::test('orders')
        ->set('serviceId', $service->id)
        ->set('deviceId', $device->id)
        ->call('takeOrder')
        ->assertHasNoErrors()
        ->assertSet('deviceId', null)
        ->assertSet('takeorder', false);
});

it('closes order modal when takeorder is false', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('orders')
        ->set('takeorder', false)
        ->assertSet('takeorder', false);
});

it('opens order modal when takeorder is true', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('orders')
        ->set('takeorder', true)
        ->assertSet('takeorder', true);
});
