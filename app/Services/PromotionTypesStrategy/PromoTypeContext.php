<?php

namespace App\Services\PromotionTypesStrategy;

use App\Services\PromotionTypesStrategy\DiscountPercentagePromotion;
use App\Services\PromotionTypesStrategy\DiscountValuePromotion;
use App\Services\PromotionTypesStrategy\PromotionType;
use Exception;


class PromoTypeContext
{

    public $promotionType ;
    public static $promoTypes = [
        'value'  => DiscountValuePromotion::class,
        'percentage'  => DiscountPercentagePromotion::class,
    ];

    public function getPromotion(string $type): PromotionType
    {
        if(isset(self::$promoTypes[$type]))
            return $this->promotionInstance(self::$promoTypes[$type]);
        throw new Exception("error don't have this promo type");
    }

    public function  promotionInstance(string $promo): PromotionType
    {
        return new $promo();
    }
}