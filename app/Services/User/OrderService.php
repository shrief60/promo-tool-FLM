<?php

namespace App\Services\User;

use App\Http\DataTransferObjects\User\OrderDto;
use App\Repositories\User\OrderRepository;
use Exception;
use App\Traits\ExceptionFailureTrait;

class OrderService
{
    use ExceptionFailureTrait;

    public function __construct(public OrderRepository $orderRepo){}

    public function createOrder(OrderDto $orderDto, array $orderData)
    {
        try{
            return $this->orderRepo->createOrder($orderDto, $orderData); 
        } catch (Exception $e) {
            return $this->handleFailure('USER_CHECK_PROMOTION_3', __('promotion_errors.USER_CHECK_PROMOTION_3'), $e);
        }
    }
}
