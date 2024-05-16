<?php

namespace App\Repositories\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\PromotionUser;

interface PromoValidityRepoInterface
{

    public function checkActivePromoCode(OrderDto $promotionDto) :Promotion|null;

    public function getPromoUsage(Promotion $promotion):int;

    public function getPromotionUser(Promotion $promotion, int $userId):PromotionUser | null;    

    public function createPromotionUser(Promotion $promotion, int $userId):PromotionUser;
}
