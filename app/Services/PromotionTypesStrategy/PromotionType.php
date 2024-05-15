<?php

namespace App\Services\PromotionTypesStrategy;

use App\Models\Promotion;
use App\Http\DataTransferObjects\User\OrderDto;

interface PromotionType
{
    public function  calculateDiscount(OrderDto $promotionDto, Promotion $promotion) : array;
}
