<?php

use App\Modules\Economy\Controllers\EconomyAccountTypeController;
use App\Modules\Economy\Controllers\EconomyCategoryController;
use App\Modules\Economy\Controllers\EconomyTransactionController;
use App\Modules\Economy\Controllers\EconomyImportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('economy/account-types', EconomyAccountTypeController::class)
        ->names('economy.account-types')
        ->parameters(['account-types' => 'accountType']);

    Route::resource('economy/categories', EconomyCategoryController::class)
        ->names('economy.categories')
        ->parameters(['categories' => 'category']);

    Route::resource('economy/transactions', EconomyTransactionController::class)
        ->names('economy.transactions')
        ->parameters(['transactions' => 'transaction']);

    Route::get('economy/import', [EconomyImportController::class, 'index'])->name('economy.import.index');
    Route::post('economy/import/preview', [EconomyImportController::class, 'preview'])->name('economy.import.preview');
    Route::post('economy/import', [EconomyImportController::class, 'import'])->name('economy.import.store');
});
