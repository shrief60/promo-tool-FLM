<?php

namespace App\Services\User;

use App\Http\DataTransferObjects\User\OrderDto;

interface OrderServiceInterface
{
    public function execute(OrderDto $orderDto, array $orderData);
}
