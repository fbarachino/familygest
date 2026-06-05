<?php

use App\Modules\FamilyMembers\Controllers\FamilyMemberApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('family-members', FamilyMemberApiController::class);
});
