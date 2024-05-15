<?php

namespace App\Http\DataTransferObjects\User;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;

class OrderDto extends DataTransferObject
{
    public string $promo_code;
    public float $price;
    public int $user_id;
}

