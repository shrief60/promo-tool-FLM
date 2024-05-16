<?php

namespace App\Repositories\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Models\Order;


interface OrderRepositoryInterface
{
    public function createOrder(OrderDto $orderDto, array $orderData) : Order;
}
