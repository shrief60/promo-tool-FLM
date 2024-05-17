<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\Admin\PromotionCreationRepository;
use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Models\Promotion;
use App\Models\PromotionUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery;

class PromotionCreationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePromotionSuccessfully()
    {        
        $promotionMock = Mockery::mock(Promotion::class);
        $promotionUserMock = Mockery::mock(PromotionUser::class);

        $promoDto = new PromoCreationRequestDto([
                'promo_code' => 'TESTCODE',
                'type' => 'discount',
                'title' => 'Test Promo',
                'desc' => 'Test Description',
                'reference_value' => 10.0,
                'user_segment' => 'all',
                'expiry_date' => '2024-12-31',
                'max_usage_times' => 100,
                'max_usage_times_per_user' => 2,
                'users' => [1,2]
        ]);
        
        $promotionMock->shouldReceive('create')
            ->once()
            ->with([
                'promo_code' => 'TESTCODE',
                'type' => 'discount',
                'title' => 'Test Promo',
                'desc' => 'Test Description',
                'reference_value' => 10.0,
                'user_segment' => 'all',
                'expiry_date' => '2024-12-31',
                'max_usage_times' => 100,
                'max_usage_times_per_user' => 2,
            ])
            ->andReturnSelf();

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($closure) {
                return $closure();
            });

        Log::shouldReceive('info')->once();

        $repository = new PromotionCreationRepository($promotionMock, $promotionUserMock);
        $promotion = $repository->createPromotion($promoDto);

        $this->assertInstanceOf(Promotion::class, $promotion);
    }

    public function testCreatePromotionWithSpecificUserSegment()
    {
        $promotionMock = Mockery::mock(Promotion::class);
        $promotionUserMock = Mockery::mock(PromotionUser::class);

        $promoDto = new PromoCreationRequestDto([
                'promo_code' => 'TESTCODE',
                'type' => 'discount',
                'title' => 'Test Promo',
                'desc' => 'Test Description',
                'reference_value' => 10.0,
                'user_segment' => Promotion::$USER_SEGMENT_SPECIFIC,
                'expiry_date' => '2024-12-31',
                'max_usage_times' => 100,
                'max_usage_times_per_user' => 2,
                'users' => [1,2]
        ]);

        $promotionMock->shouldReceive('create')
            ->once()
            ->with([
                'promo_code' => 'TESTCODE',
                'type' => 'discount',
                'title' => 'Test Promo',
                'desc' => 'Test Description',
                'reference_value' => 10.0,
                'user_segment' => Promotion::$USER_SEGMENT_SPECIFIC,
                'expiry_date' => '2024-12-31',
                'max_usage_times' => 100,
                'max_usage_times_per_user' => 2,
            ])
            ->andReturn(new Promotion([
                'id' => 2,
                'promo_code' => 'TESTCODE',
                'type' => 'discount',
                'title' => 'Test Promo',
                'desc' => 'Test Description',
                'reference_value' => 10.0,
                'user_segment' => Promotion::$USER_SEGMENT_SPECIFIC,
                'expiry_date' => '2024-12-31',
                'max_usage_times' => 100,
                'max_usage_times_per_user' => 2,
                'created_at' => '2024-05-15 08:52:32',
                'updated_at' => '2024-05-15 08:52:32'
            ]));
        
        $promotionUserMock->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(function ($promotionUsers) {
                return count($promotionUsers) === 2;
            }));

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($closure) {
                return $closure();
            });

        Log::shouldReceive('info')->once();

        $repository = new PromotionCreationRepository($promotionMock, $promotionUserMock);

        $promotion = $repository->createPromotion($promoDto);

        $this->assertInstanceOf(Promotion::class, $promotion);
    }

    public function testAttachUsers()
    {
        $promotionMock = Mockery::mock(Promotion::class);
        $promotionUserMock = Mockery::mock(PromotionUser::class);

        $repository = new PromotionCreationRepository($promotionMock, $promotionUserMock);

        $users = [1, 2, 3];
        $maxUsageTimesPerUser = 10;
        $promotionId = 1;

        $promotionUsers = $repository->attachUsers($users, $maxUsageTimesPerUser, $promotionId);

        $this->assertCount(3, $promotionUsers);
        foreach ($promotionUsers as $promoUser) {
            $this->assertEquals($promotionId, $promoUser['promotion_id']);
            $this->assertContains($promoUser['user_id'], $users);
            $this->assertEquals($maxUsageTimesPerUser, $promoUser['available_usage_times']);
        }
    }
}