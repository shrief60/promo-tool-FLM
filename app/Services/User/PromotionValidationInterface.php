<?php

namespace App\Services\User;

use App\Exceptions\PromotionVaidityException;
use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Promotion;
use App\Repositories\User\OrderRepository;
use Exception;
use App\Repositories\User\PromotionValidityRepository;
use App\Services\PromotionTypesStrategy\PromoTypeContext;
use App\Traits\ExceptionFailureTrait;
use App\Traits\PromotionValidtyFailureTrait;

interface PromotionValidationInterface
{
    public function execute(OrderDto $promotionDto) : array;

    public function IsPromoUsageExceeded(Promotion $promotion) : bool;
   
    public function IsPromoValidForUser(Promotion $promotion, int $userId): bool;

    public function isPublicPromo(Promotion $promotion) : bool;

    public function isSpecificPromo(Promotion $promotion) : bool;

    public function applyPromotion(Promotion $promotion, OrderDto $promotionDto) : array;
   
}
