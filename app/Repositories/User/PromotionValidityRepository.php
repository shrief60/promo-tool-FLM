<?php

namespace App\Repositories\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\PromotionUser;

class PromotionValidityRepository implements PromoValidityRepoInterface
{
    public function  __construct(public Promotion $promotionModel, public PromotionUser $promotionUsersModel, public Order $orderModel){}

    public function checkActivePromoCode(OrderDto $promotionDto) :Promotion|null
    {
        return $this->promotionModel->where('promo_code', $promotionDto->promo_code)
        ->where('is_expired' , 0)->where('expiry_date' ,'>', now())->first();
    }

    public function getPromoUsage(Promotion $promotion):int
    {
        return $this->orderModel->where('promotion_id', $promotion->id)->count();
    }

    public function getPromotionUser(Promotion $promotion, int $userId):PromotionUser | null
    {
        return $this->promotionUsersModel->where('promotion_id', $promotion->id)->where('user_id', $userId)->First();
    }

    public function createPromotionUser(Promotion $promotion, int $userId):PromotionUser
    {
        return $this->promotionUsersModel->create([
            'promotion_id' => $promotion->id,
            'user_id' => $userId,
            'available_usage_times' => $promotion->max_usage_times_per_user -1
        ]);
    }
}
