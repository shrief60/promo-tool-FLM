<?php

namespace Tests\Unit;

use App\Formatters\FailureFormatter;
use App\Http\DataTransferObjects\User\OrderDto;
use App\Repositories\User\OrderRepositoryInterface;
use App\Services\User\OrderService;
use App\Models\Order;
use Exception;
use Tests\TestCase;
use Mockery;

class OrderServiceTest extends TestCase
{
    protected $orderRepo;
    protected $formatter;
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class);
        $this->formatter = Mockery::mock(FailureFormatter::class);
        $this->orderService = new OrderService($this->orderRepo, $this->formatter);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testExecuteSuccess()
    {
        $orderDto = new OrderDto([
            'promo_code' => 'test',
            'price' => 100,
            'user_id' => 1
        ]);
        $orderData = [
            'promotion_id' => 1,
            'price' => 100,
            'discount_amount' => 10,
            'final_price' => 90
        ];
        $order = new Order([
            'user_id' => $orderDto->user_id,
            'promotion_id' => $orderData['promotion_id'],
            'total_price' => $orderData['price'],
            'discount_amount' => $orderData['discount_amount'],
            'final_price' => $orderData['final_price'],
            'status' => Order::$STATUS_PENDING,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $this->orderRepo
            ->shouldReceive('createOrder')
            ->once()
            ->with($orderDto, $orderData)
            ->andReturn($order);

        $result = $this->orderService->execute($orderDto, $orderData);

        $this->assertEquals($order, $result);
    }

    public function testExecuteFailure()
    {
        $orderDto = new OrderDto([
            'promo_code' => 'test',
            'price' => 100,
            'user_id' => 1
        ]);
        $orderData = [
            'promotion_id' => 1,
            'price' => 100,
            'discount_amount' => 10,
            'final_price' => 90
        ];
        $exception = new Exception('Database error');

        $this->orderRepo
            ->shouldReceive('createOrder')
            ->once()
            ->with($orderDto, $orderData)
            ->andThrow($exception);

        $this->formatter
            ->shouldReceive('handle')
            ->once()
            ->with('USER_CHECK_PROMOTION_3', __('promotion_errors.USER_CHECK_PROMOTION_3'), $exception)
            ->andReturn([
                'success' => false,
                'error_code' => 403,
                'error_message' => "",
                'additional_data' => [
                    'exception_details' => [
                        'message' => "",
                        'file' => "",
                        'line' => ""
                    ]
                ]
            ]);

        $result = $this->orderService->execute($orderDto, $orderData);
        $this->assertEquals([
            'success' => false,
            'error_code' => 403,
            'error_message' => "",
            'additional_data' => [
                'exception_details' => [
                    'message' => "",
                    'file' => "",
                    'line' => ""
                ]
            ]], $result);
    }
}