<?php

namespace App\Services\Admin;

use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;

interface PromoCreationInterface
{
    public function createPromotion(PromoCreationRequestDto $promotionDto) : array;
}
