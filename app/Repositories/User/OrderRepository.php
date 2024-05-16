<?php

namespace App\Repositories\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Order;


class OrderRepository implements OrderRepositoryInterface
{
    public function  __construct(public Order $orderModel){}

    public function createOrder(OrderDto $orderDto, array $orderData) : Order
    {
        $order =  $this->orderModel->create([
            'user_id' => $orderDto->user_id,
            'promotion_id' => $orderData['promotion_id'],
            'total_price' => $orderData['price'],
            'discount_amount' => $orderData['discount_amount'],
            'final_price' => $orderData['final_price'],
            'status' => Order::$STATUS_PENDING,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return $order;
    }

   
}
