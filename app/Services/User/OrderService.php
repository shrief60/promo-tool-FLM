<?php

namespace App\Services\User;

use App\Formatters\FailureFormatter;
use App\Http\DataTransferObjects\User\OrderDto;
use App\Repositories\User\OrderRepositoryInterface;
use Exception;
use App\Traits\ExceptionFailureTrait;

class OrderService implements OrderServiceInterface
{
    public function __construct(public OrderRepositoryInterface $orderRepo, public FailureFormatter $formatter){}

    public function execute(OrderDto $orderDto, array $orderData)
    {
        try{
            return $this->orderRepo->createOrder($orderDto, $orderData); 
        } catch (Exception $e) {
            return $this->formatter->handle('USER_CHECK_PROMOTION_3', __('promotion_errors.USER_CHECK_PROMOTION_3'), $e);
        }
    }
}
