<?php
namespace Tests\Unit;


use App\Formatters\FailureFormatter;
use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Models\Promotion;
use App\Repositories\Admin\PromotionCreationRepository;
use App\Services\Admin\PromotionCreationService;
use Exception;
use Tests\TestCase;
use Mockery;

class PromotionCreationServiceTest extends TestCase
{
    protected $promoRepository;
    protected $formatter;
    protected $promotionCreationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->promoRepository = Mockery::mock(PromotionCreationRepository::class);
        $this->formatter = Mockery::mock(FailureFormatter::class);
        $this->promotionCreationService = new PromotionCreationService($this->promoRepository, $this->formatter);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreatePromotionSuccess()
    {
        $promotionDto = Mockery::mock(PromoCreationRequestDto::class);
        $expectedResponse = new Promotion([
            'promo_code' => 'PROMO_CODE',
            'type' => Promotion::$PROMOTION_TYPE_VALUE,
            'title' => 'PROMO_TITLE',
            'desc' => 'PROMO_DESC',
            'reference_value' => 100,
            'is_expired' => false,
            'user_segment' => Promotion::$USER_SEGMENT_ALL,
            'expiry_date' => now()->addDays(10),
            'max_usage_times' => 5,
            'max_usage_times_per_user' => 2,
        ]);

        $this->promoRepository
            ->shouldReceive('createPromotion')
            ->once()
            ->with($promotionDto)
            ->andReturn($expectedResponse);

        $result = $this->promotionCreationService->createPromotion($promotionDto);

        $this->assertTrue($result['success']);
        $this->assertEquals($expectedResponse, $result['result']);
    }

    public function testCreatePromotionFailure()
    {
        $promotionDto = Mockery::mock(PromoCreationRequestDto::class);
        $exception = new Exception('Database error');

        $this->promoRepository
            ->shouldReceive('createPromotion')
            ->once()
            ->with($promotionDto)
            ->andThrow($exception);

        $this->formatter
            ->shouldReceive('handle')
            ->once()
            ->with('ADMIN_CREATE_PROMOTION_1', __('promotion_errors.ADMIN_PROMOTION_1'), $exception)
            ->andReturn(['success' => false, 'error' => 'failure_handled']);

        $result = $this->promotionCreationService->createPromotion($promotionDto);

        $this->assertFalse($result['success']);
        $this->assertEquals('failure_handled', $result['error']);
    }
}