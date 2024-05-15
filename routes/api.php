<?php

use App\Http\Controllers\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('dummy-auth')->group(function () {
    Route::post('promotions', [PromotionController::class, 'store']);
});

Route::middleware('dummy-auth')->group(function () {
    
});