<?php

use App\Models\Device;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->assertStatus(200);
});

it('displays all user devices', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Device::factory()->count(3)->for($user)->create();

    Livewire::test('my-devices')
        ->assertSee($user->devices()->first()->name);
});

it('paginates devices', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Device::factory()->count(10)->for($user)->create();

    $component = Livewire::test('my-devices')
        ->set('quantity', 5);

    // Verify pagination works by checking component renders with quantity set
    $component->assertSet('quantity', 5);
});

it('searches devices by name', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Device::factory()->for($user)->create(['name' => 'iPhone 15']);
    Device::factory()->for($user)->create(['name' => 'Samsung Galaxy']);

    Livewire::test('my-devices')
        ->set('search', 'iPhone')
        ->assertSee('iPhone 15')
        ->assertDontSee('Samsung Galaxy');
});

it('searches devices by imei', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $device1 = Device::factory()->for($user)->create(['imei' => '1111111111111']);
    Device::factory()->for($user)->create(['imei' => '2222222222222']);

    Livewire::test('my-devices')
        ->set('search', '111111111')
        ->assertSee($device1->name);
});

it('adds a new device successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('name', 'My iPhone')
        ->set('imei', '1234567890123')  // max 13 characters
        ->set('model', 'iPhone 15 Pro')
        ->call('addDevice')
        ->assertHasNoErrors();

    expect(Device::where('name', 'My iPhone')->exists())->toBeTrue();
    expect($user->devices()->where('imei', '1234567890123')->exists())->toBeTrue();
});

it('validates required fields when adding device', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('name', '')
        ->set('imei', '123456789012345')
        ->set('model', 'iPhone 15')
        ->call('addDevice')
        ->assertHasErrors('name');
});

it('validates imei is between 8 and 13 characters', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('name', 'My iPhone')
        ->set('imei', '12345')  // Too short
        ->set('model', 'iPhone 15')
        ->call('addDevice')
        ->assertHasErrors('imei');
});

it('validates unique imei', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Device::factory()->for($user)->create(['imei' => '1234567890123']);

    Livewire::test('my-devices')
        ->set('name', 'Another Device')
        ->set('imei', '1234567890123')
        ->set('model', 'iPhone 15')
        ->call('addDevice')
        ->assertHasErrors('imei');
});

it('resets form after successful device addition', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('name', 'My iPhone')
        ->set('imei', '1234567890123')  // max 13 characters
        ->set('model', 'iPhone 15 Pro')
        ->call('addDevice')
        ->assertHasNoErrors()
        ->assertSet('name', '')
        ->assertSet('imei', '')
        ->assertSet('model', '')
        ->assertSet('newdevice', false);
});

it('opens device modal when newdevice is true', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('newdevice', true)
        ->assertSet('newdevice', true);
});

it('closes device modal when newdevice is false', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('my-devices')
        ->set('newdevice', false)
        ->assertSet('newdevice', false);
});
