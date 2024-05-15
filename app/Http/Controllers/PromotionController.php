<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Requests\PromotionCreationRequest;
use App\Services\PromotionCreationService;

class PromotionController extends Controller
{

    public function  __construct(public PromotionCreationService $promotionService){}

    public function store(PromotionCreationRequest $request) : \Illuminate\Http\JsonResponse
    {
        $promotionDto = $request->toDto();
        $response = $this->promotionService->createPromotion($promotionDto);
        if(!$response['success'])
            throw new APIException($response['error_message'], $response['error_code'], 403, $response['additional_data']);
        return response()->json(['message' => 'Promotion created successfully', 'promotion' => $response['result']]);
    }
}
