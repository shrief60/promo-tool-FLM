<?php

namespace Tests\Unit;

use App\Models\Promotion;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $promotion = new Promotion([
            'promo_code' => 'TESTCODE',
            'type' => Promotion::$PROMOTION_TYPE_VALUE,
            'title' => 'Test Promotion',
            'desc' => 'Test Description',
            'reference_value' => 100,
            'is_expired' => false,
            'user_segment' => Promotion::$USER_SEGMENT_ALL,
            'expiry_date' => now()->addDays(10),
            'max_usage_times' => 10,
            'max_usage_times_per_user' => 2,
        ]);

        $this->assertEquals('TESTCODE', $promotion->promo_code);
        $this->assertEquals(Promotion::$PROMOTION_TYPE_VALUE, $promotion->type);
        $this->assertEquals('Test Promotion', $promotion->title);
        $this->assertEquals('Test Description', $promotion->desc);
        $this->assertEquals(100, $promotion->reference_value);
        $this->assertEquals(false, $promotion->is_expired);
        $this->assertEquals(Promotion::$USER_SEGMENT_ALL, $promotion->user_segment);
        $this->assertEquals(10, $promotion->max_usage_times);
        $this->assertEquals(2, $promotion->max_usage_times_per_user);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $promotion = Promotion::factory()->create();
        Order::factory()->count(3)->create(['promotion_id' => $promotion->id]);

        $this->assertCount(3, $promotion->refresh()->orders);
    }

    /** @test */
    public function it_belongs_to_many_users()
    {
        $promotion = Promotion::factory()->create();
        User::factory()->count(3)->create()->each(function ($user) use ($promotion) {
            $promotion->users()->attach($user, ['available_usage_times' => 2]);
        });

        $this->assertCount(3, $promotion->refresh()->users);
    }
}