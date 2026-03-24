<?php

use App\Models\Manager;
use Livewire\Livewire;

test('Manager login screen can renders successfully', function () {
    Livewire::test('manager.login')
        ->assertStatus(200);
});

test("Manager can login", function () {
    $manager = Manager::factory()->create();
    Livewire::test('manager.login')
        ->set('email', $manager->email)
        ->set('password', 'password')
        ->call('login')
        ->assertRedirectToRoute('manager.dashboard');
});


test("Manager can't login with invalid creds", function () {
    $manager = Manager::factory()->create();
    Livewire::test('manager.login')
        ->set('email', $manager->email)
        ->set('password', 'passwo')
        ->call('login')
        ->assertHasErrors('email');
});

// test("manager can logout", function () {
//     $manager = Manager::factory()->create();
//     $response = $this->actingAs($manager)->post(route('manager.logout'));

//     $response->assertRedirect(route('manager.login'));

//     $this->assertGuest();
// });
