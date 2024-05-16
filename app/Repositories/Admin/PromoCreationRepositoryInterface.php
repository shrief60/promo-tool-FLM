<?php

namespace App\Repositories\Admin;

use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Models\Promotion;

interface PromoCreationRepositoryInterface
{
    public function createPromotion(PromoCreationRequestDto $promoDto) :Promotion|null;

    public function attachUsers($users, $maxUsageTimesPerUser, $promotion_id);
}
