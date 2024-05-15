<?php

use App\Http\Controllers\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('dummy-admin-auth')->group(function () {
    Route::post('promotions', [PromotionController::class, 'store']);
});

Route::middleware('dummy-user-auth')->group(function () {
    
});