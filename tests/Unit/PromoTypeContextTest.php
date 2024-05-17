<?php

namespace Tests\Unit;

use App\Services\PromotionTypesStrategy\PromoTypeContext;
use App\Services\PromotionTypesStrategy\DiscountPercentagePromotion;
use App\Services\PromotionTypesStrategy\DiscountValuePromotion;
use App\Services\PromotionTypesStrategy\PromotionType;
use Exception;
use PHPUnit\Framework\TestCase;

class PromoTypeContextTest extends TestCase
{
    protected $promoTypeContext;

    protected function setUp(): void
    {
        parent::setUp();
        $this->promoTypeContext = new PromoTypeContext();
    }

    public function testGetPromotionWithValidTypeValue()
    {
        $promotion = $this->promoTypeContext->getPromotion('value');
        $this->assertInstanceOf(DiscountValuePromotion::class, $promotion);
    }

    public function testGetPromotionWithValidTypePercentage()
    {
        $promotion = $this->promoTypeContext->getPromotion('percentage');
        $this->assertInstanceOf(DiscountPercentagePromotion::class, $promotion);
    }

    public function testGetPromotionWithInvalidType()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("error don't have this promo type");
        $this->promoTypeContext->getPromotion('invalid');
    }
}