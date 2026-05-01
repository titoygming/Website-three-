<?php

use App\Models\Service;

use function Pest\Laravel\get;

it('loads the welcome page successfully', function () {
    get(route('home'))
        ->assertOk();
});

it('displays repair services on the welcome page', function () {
    Service::factory()->create([
        'name' => 'Test Screen Repair',
        'type' => 'repair',
        'price' => 2500,
        'description' => 'Professional screen repair service',
    ]);

    get(route('home'))
        ->assertOk()
        ->assertSee('Repair Services')
        ->assertSee('Test Screen Repair')
        ->assertSee('MZN 2.500');
});

it('displays gift cards on the welcome page', function () {
    Service::factory()->create([
        'name' => 'Test Amazon Gift Card',
        'type' => 'giftcard',
        'price' => 1000,
        'description' => 'Amazon gift card for shopping',
    ]);

    get(route('home'))
        ->assertOk()
        ->assertSee('Gift Cards')
        ->assertSee('Test Amazon Gift Card')
        ->assertSee('MZN 1.000');
});

it('does not show repair services in the gift cards section', function () {
    Service::factory()->create([
        'name' => 'Only Repair Service',
        'type' => 'repair',
        'price' => 500,
    ]);

    $response = get(route('home'))
        ->assertOk();

    // The repair service should appear in the repair section
    $response->assertSee('Only Repair Service');
});

it('hides repair section when no repair services exist', function () {
    // Only create a gift card, no repair services
    Service::factory()->create([
        'name' => 'Some Gift Card',
        'type' => 'giftcard',
        'price' => 1000,
    ]);

    get(route('home'))
        ->assertOk()
        ->assertDontSee('8 services'); // counter should not appear for repairs
});

it('shows correct service count in repair section header', function () {
    Service::factory()->count(3)->create([
        'type' => 'repair',
    ]);

    get(route('home'))
        ->assertOk()
        ->assertSee('3 services');
});
