<?php

namespace App\Services;

use App\Http\DataTransferObjects\PromoCreationRequestDto;
use Exception;
use App\Repositories\PromotionCreationRepository;


use App\Traits\ExceptionFailureTrait;

class PromotionCreationService
{
    use ExceptionFailureTrait;

    public $promoCreationRepository;

    public function __construct(public PromotionCreationRepository $promoRepository){}

    
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
