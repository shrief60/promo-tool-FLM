<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public static $STATUS_PENDING = 'pending';
    public static $STATUS_COMPLETED = 'completed';
    public static $STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'promotion_id',
        'total_price',
        'discount_amount',
        'final_price',
        'status',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
