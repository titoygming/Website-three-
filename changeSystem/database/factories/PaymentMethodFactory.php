<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'number' => fake()->phoneNumber(),
            'holder_name' => fake()->name(),
            'provider' => fake()->word(),
            'status' => fake()->randomElement(Status::toArray()),
        ];
    }
}
