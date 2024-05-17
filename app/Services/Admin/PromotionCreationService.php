<?php

namespace App\Services\Admin;

use App\Formatters\FailureFormatter;
use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Repositories\Admin\PromoCreationRepositoryInterface;
use Exception;

class PromotionCreationService implements PromoCreationInterface
{
    public function __construct(public PromoCreationRepositoryInterface $promoRepository, public FailureFormatter $formatter){}
    
    public function createPromotion(PromoCreationRequestDto $promotionDto) : array
    {
        try {
            $response = $this->promoRepository->createPromotion($promotionDto);
            return ['success' => true, 'result' => $response];
        } catch (Exception $e) {
            return $this->formatter->handle('ADMIN_CREATE_PROMOTION_1', __('promotion_errors.ADMIN_PROMOTION_1'), $e);
        }
    }
}
