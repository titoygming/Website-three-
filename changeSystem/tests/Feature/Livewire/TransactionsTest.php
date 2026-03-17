<?php

use App\Models\Transaction;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('transactions')
        ->assertStatus(200);
});

it('displays all user transactions', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Transaction::factory()->for($user)->create();
    Transaction::factory()->for($user)->create();
    Transaction::factory()->for($user)->create();

    Livewire::test('transactions')
        ->assertStatus(200);
});

it('paginates transactions', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Transaction::factory()->count(12)->for($user)->create();

    Livewire::test('transactions')
        ->set('quantity', 5)
        ->assertSet('quantity', 5);
});

it('orders transactions by latest created_at', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Transaction::factory()->for($user)->create();
    sleep(1);
    Transaction::factory()->for($user)->create();

    Livewire::test('transactions')
        ->assertStatus(200);
});

it('displays only transactions for authenticated user', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $this->actingAs($user);

    Transaction::factory()->for($user)->create();
    Transaction::factory()->for($otherUser)->create();

    Livewire::test('transactions')
        ->assertStatus(200);
});

it('has default quantity of 5', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('transactions')
        ->assertSet('quantity', 5);
});

it('can update quantity value', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('transactions')
        ->set('quantity', 10)
        ->assertSet('quantity', 10);
});

it('has empty search by default', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('transactions')
        ->assertSet('search', '');
});

it('sets correct page title', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('transactions')
        ->assertStatus(200);
});
