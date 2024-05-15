<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\APIException;
use App\Http\Requests\Admin\PromotionCreationRequest;
use App\Services\Admin\PromotionCreationService;
use App\Http\Controllers\Controller;

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
