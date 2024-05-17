<?php

namespace App\Services\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Promotion;
use App\Repositories\User\OrderRepositoryInterface;
use Exception;
use App\Repositories\User\PromoValidityRepoInterface;
use App\Services\PromotionTypesStrategy\PromoTypeContext;
use App\Traits\ExceptionFailureTrait;
use App\Traits\PromotionValidtyFailureTrait;

class PromotionValidationService implements PromotionValidationInterface
{
    use ExceptionFailureTrait, PromotionValidtyFailureTrait;

    public function __construct(public PromoValidityRepoInterface $promoRepository, public OrderRepositoryInterface $orderRepo){}

    
    public function execute(OrderDto $promotionDto) : array
    {
        try {
            $promotion = $this->promoRepository->checkActivePromoCode($promotionDto);
            if(!$promotion)
                return $this->handleNotValidPromo('USER_PROMOTION_1');
            if(!$this->IsPromoUsageExceeded($promotion))
                return $this->handleNotValidPromo('USER_PROMOTION_2');
            if(!$this->IsPromoValidForUser($promotion, $promotionDto->user_id))
                return $this->handleNotValidPromo('USER_PROMOTION_3');

            $response = $this->applyPromotion($promotion, $promotionDto);
            return ['success' => true, 'result' => $response];
        } catch (Exception $e) {
            return $this->handleFailure('USER_CHECK_PROMOTION_3', __('promotion_errors.USER_CHECK_PROMOTION_4'), $e);
        }
    } 

    public function IsPromoUsageExceeded(Promotion $promotion) : bool
    {
        return $this->promoRepository->getPromoUsage($promotion) < $promotion->max_usage_times ? true : false;    
    }

    public function IsPromoValidForUser(Promotion $promotion, int $userId): bool
    {
        $promotionUsage = $this->promoRepository->getPromotionUser($promotion, $userId);
        if($this->isPublicPromo($promotion) && $promotionUsage && $promotionUsage?->available_usage_times <= 0)
            return false;
        if($this->isSpecificPromo($promotion) && $promotionUsage?->available_usage_times <= 0)
            return false;

        return true;
    }

    public function isPublicPromo(Promotion $promotion) : bool
    {
        return $promotion->user_segment == Promotion::$USER_SEGMENT_ALL;
    }

    public function isSpecificPromo(Promotion $promotion) : bool
    {
        return $promotion->user_segment == Promotion::$USER_SEGMENT_SPECIFIC;
    }

    public function applyPromotion(Promotion $promotion, OrderDto $promotionDto) : array
    {
        $promotionUser = $this->promoRepository->getPromotionUser($promotion, $promotionDto->user_id);
        if(($promotionUser && $this->isPublicPromo($promotion)) || $this->isSpecificPromo($promotion))
        {
            $promotionUser->available_usage_times -= 1;
            $promotionUser->save();
        } else {
            $this->promoRepository->createPromotionUser($promotion, $promotionDto->user_id);
        }
        
        $context = new PromoTypeContext();
        return $context->getPromotion($promotion->type)->calculateDiscount($promotionDto, $promotion);
        
    }
}
