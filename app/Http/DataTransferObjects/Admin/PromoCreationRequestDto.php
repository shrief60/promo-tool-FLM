<?php

namespace App\Http\DataTransferObjects\Admin;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;

class PromoCreationRequestDto extends DataTransferObject
{
    public string $promo_code;
    public string $type;
    public ?string $title;
    public ?string $desc;
    public float $reference_value;
    public string $user_segment;
    public string $expiry_date;
    public int $max_usage_times;
    public int $max_usage_times_per_user;
    public array $users;

}

