<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Device;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory();

        return [
            'user_id' => $user,
            'device_id' => Device::factory()->for($user),
            'service_id' => Service::factory(),
            'transaction_id' => Transaction::factory()->for($user),
            'status' => fake()->randomElement(array_map(fn($case) => $case->value, OrderStatus::cases())),
            'amount' => $this->faker->numberBetween(10, 500),
        ];
    }
}
