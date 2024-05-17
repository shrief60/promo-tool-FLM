<?php

namespace App\Traits;

use Exception;
trait PromotionValidtyFailureTrait
{
    public function handleNotValidPromo(string $errorCode): array
    {
        return [
            'success' => false,
            'error_code' => $errorCode,
            'error_message' => __('promotion_errors.'. $errorCode),
        ];
    }
}
