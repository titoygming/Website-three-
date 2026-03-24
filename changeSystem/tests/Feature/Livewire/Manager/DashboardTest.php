<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('manager.dashboard')
        ->assertStatus(200);
});
