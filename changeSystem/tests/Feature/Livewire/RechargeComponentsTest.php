<?php

use App\Models\User;
use App\Enums\RechargeRequestStatus;
use App\Models\RechargeRequest;
use App\Models\PaymentMethod;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('recharge-form')
        ->assertStatus(200);
});

it('displays payment methods', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    PaymentMethod::factory()->count(2)->create();

    $component = Livewire::test('recharge-form');
    $component->assertStatus(200);
    $component->assertViewHas('paymentMethods');
});

it('validates required fields', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $component = Livewire::test('recharge-form')
        ->set('amount', '')
        ->set('paymentMethod', '')
        ->call('submit');

    $component->assertHasErrors(['amount', 'paymentMethod']);
});

it('validates amount is numeric', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $component = Livewire::test('recharge-form')
        ->set('amount', 'not-a-number')
        ->call('submit');

    $component->assertHasErrors('amount');
});

it('validates minimum amount', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $component = Livewire::test('recharge-form')
        ->set('amount', '5')
        ->call('submit');

    $component->assertHasErrors('amount');
});

it('displays recharge requests list', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    RechargeRequest::factory()->count(3)->for($user)->create();

    Livewire::test('recharge-requests')
        ->assertStatus(200)
        ->assertViewHas('rechargeRequests');
});

it('searches recharge requests by amount', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    RechargeRequest::factory()->for($user)->create(['amount' => 1000]);
    RechargeRequest::factory()->for($user)->create(['amount' => 5000]);

    $component = Livewire::test('recharge-requests')
        ->set('search', '1000');

    $component->assertStatus(200);
});

it('paginates recharge requests', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    RechargeRequest::factory()->count(20)->for($user)->create();

    $component = Livewire::test('recharge-requests')
        ->set('quantity', 10);

    expect($component->viewData('rechargeRequests'))->toHaveCount(10);
});

it('displays only user own recharge requests', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    RechargeRequest::factory()->count(3)->for($user1)->create();
    RechargeRequest::factory()->count(5)->for($user2)->create();

    $this->actingAs($user1);

    $component = Livewire::test('recharge-requests');

    expect($component->viewData('rechargeRequests'))->toHaveCount(3);
});
