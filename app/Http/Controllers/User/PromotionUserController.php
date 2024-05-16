<?php

namespace App\Http\Controllers\User;

use App\Exceptions\APIException;
use App\Exceptions\PromotionVaidityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\PromotionValidityRequest;
use App\Services\User\OrderServiceInterface;
use App\Services\User\PromotionValidationInterface;

class PromotionUserController extends Controller
{

    public function  __construct(public PromotionValidationInterface $promotionService, 
                                 public OrderServiceInterface $orderService){}

    public function checkValidity(PromotionValidityRequest $request) : \Illuminate\Http\JsonResponse
    {
        $promotionDto = $request->toDto();
        $response = $this->promotionService->execute($promotionDto);
        
        if(!$response['success'])
            throw new PromotionVaidityException($response['error_message'], $response['error_code'], 404);
        // smulate order creation  to  check promotion max usage exceeded 
        $this->orderService->execute($promotionDto, $response['result']);

        return response()->json(['message' => 'Promotion is valid', 'promotion' => $response['result']]);
    }
}
