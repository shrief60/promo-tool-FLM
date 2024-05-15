<?php

namespace App\Repositories\Admin;

use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use App\Models\Promotion;
use App\Models\PromotionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionCreationRepository
{
    private $promotion;
    public function  __construct(public Promotion $promotionModel, public PromotionUser $promotionUsersModel){}

    public function createPromotion(PromoCreationRequestDto $promoDto) :Promotion|null
    {
        $this->promotion = null;
        $result = DB::transaction(function () use ($promoDto) {
            $this->promotion = $this->promotionModel->create([
                'promo_code' => $promoDto->promo_code,
                'type' => $promoDto->type,
                'title' => $promoDto->title,
                'desc' => $promoDto->desc,
                'reference_value' => $promoDto->reference_value,
                'user_segment' => $promoDto->user_segment,
                'expiry_date' => $promoDto->expiry_date,
                'max_usage_times' => $promoDto->max_usage_times,
            ]);
            if($promoDto->user_segment == Promotion::$USER_SEGMENT_SPECIFIC && !empty($promoDto->users))
            {
                $promotionUsers = $this->attachUsers($promoDto->users, $promoDto->max_usage_times_per_user, $this->promotion->id);
                $this->promotionUsersModel->insert($promotionUsers);
            }
        });
        Log::info(__CLASS__." ".__FUNCTION__." saving promotion transaction response", ['promotion' =>$this->promotionModel, 'result' => $result ] );
        return $this->promotion;
    }

    public function attachUsers($users, $maxUsageTimesPerUser, $promotion_id)
    {
        $promoUsers = array();
        foreach ($users as $user){
            $promoUser = [
                'promotion_id' => $promotion_id,
                'user_id' => $user,
                'available_usage_times' => $maxUsageTimesPerUser,
            ];
            array_push($promoUsers, $promoUser);
        }
        return $promoUsers;
    }
}
