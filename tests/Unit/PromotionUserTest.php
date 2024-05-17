<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PromotionUser;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class PromotionUserTest extends TestCase
{
    public $promotion ;
    public $user;
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->promotion = Promotion::factory()->create();
        $this->user = User::create([
            'name' => 'User 1',
            'email' => 'sherif@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }

    public function testFillableAttributes()
    {
        
        $data = [
            'promotion_id' => $this->promotion->id,
            'user_id' => $this->user->id,
            'available_usage_times' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $promotionUser = PromotionUser::create($data);

        $this->assertInstanceOf(PromotionUser::class, $promotionUser);
        $this->assertEquals(1, $promotionUser->promotion_id);
        $this->assertEquals(1, $promotionUser->user_id);
        $this->assertEquals(10, $promotionUser->available_usage_times);
    }

    public function testPromotionRelationship()
    {
        $promotion = Promotion::factory()->create();
        $promotionUser = PromotionUser::factory()->create(['promotion_id' => $promotion->id, 'user_id' => $this->user->id, 'available_usage_times' => 10]);

        $this->assertInstanceOf(Promotion::class, $promotionUser->promotion);
        $this->assertEquals($promotion->id, $promotionUser->promotion->id);
    }

    public function testUserRelationship()
    {
        $user = User::factory()->create();
        $promotionUser = PromotionUser::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $promotionUser->user);
        $this->assertEquals($user->id, $promotionUser->user->id);
    }
}