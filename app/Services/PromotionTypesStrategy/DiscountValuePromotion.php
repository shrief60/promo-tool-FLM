<?php

namespace App\Services\PromotionTypesStrategy;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Promotion;

class DiscountValuePromotion implements PromotionType
{
    public function calculateDiscount(OrderDto $promotionDto, Promotion $promotion) : array
    {
        $discount_amount = $promotion->reference_value;
        return [
            'price' => $promotionDto->price,
            'discount_amount' => $discount_amount,
            'final_price' => $promotionDto->price - $discount_amount,
            'promotion_id' => $promotion->id,
        ];
    }

}
