<?php

use App\Modules\Economy\Controllers\EconomyAccountTypeApiController;
use App\Modules\Economy\Controllers\EconomyCategoryApiController;
use App\Modules\Economy\Controllers\EconomyTransactionApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('economy')->group(function () {
    Route::apiResource('account-types', EconomyAccountTypeApiController::class)
        ->parameters(['account-types' => 'accountType']);

    Route::apiResource('categories', EconomyCategoryApiController::class);

    Route::apiResource('transactions', EconomyTransactionApiController::class)
        ->parameters(['transactions' => 'transaction']);
});
