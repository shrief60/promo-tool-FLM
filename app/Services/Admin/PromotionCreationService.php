<?php

namespace App\Services\Admin;

use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Repositories\Admin\PromoCreationRepositoryInterface;
use Exception;


use App\Traits\ExceptionFailureTrait;

class PromotionCreationService implements PromoCreationInterface
{
    use ExceptionFailureTrait;

    public function __construct(public PromoCreationRepositoryInterface $promoRepository){}
    
    public function createPromotion(PromoCreationRequestDto $promotionDto) : array
    {
        try {
            $response = $this->promoRepository->createPromotion($promotionDto);
            return ['success' => true, 'result' => $response];
        } catch (Exception $e) {
            return $this->handleFailure('ADMIN_CREATE_PROMOTION_1', __('promotion_errors.ADMIN_PROMOTION_1'), $e);
        }

    }
}
