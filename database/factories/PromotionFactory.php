<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'promo_code' => $this->faker->unique()->word,
            'type' => \App\Models\Promotion::$PROMOTION_TYPE_VALUE,
            'title' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'reference_value' => $this->faker->numberBetween(100, 1000),
            'is_expired' => false,
            'user_segment' => \App\Models\Promotion::$USER_SEGMENT_ALL,
            'expiry_date' => now()->addDays(10),
            'max_usage_times' => $this->faker->numberBetween(1, 10),
            'max_usage_times_per_user' => $this->faker->numberBetween(1, 5),
        ];
    }
}
