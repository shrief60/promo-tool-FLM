<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    public static $USER_SEGMENT_ALL = 'all';
    public static $USER_SEGMENT_SPECIFIC = 'specific';
    public static $PROMOTION_TYPE_VALUE = 'value';
    public static $PROMOTION_TYPE_PERCENTAGE = 'percentage';

    protected $fillable = [
        'promo_code',
        'type',
        'title',
        'desc',
        'reference_value',
        'is_expired',
        'user_segment',
        'expiry_date',
        'max_usage_times',
        'max_usage_times_per_user',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_users')->withPivot('available_usage_times');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
