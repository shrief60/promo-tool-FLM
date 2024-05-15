<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
        return [
            'user_id' => User::factory(),
            'promotion_id' => Promotion::factory(),
            'total_price' => $this->faker->numberBetween(100, 1000),
            'discount_amount' => $this->faker->numberBetween(10, 100),
            'final_price' => $this->faker->numberBetween(90, 900),
            'status' => Order::$STATUS_PENDING,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
