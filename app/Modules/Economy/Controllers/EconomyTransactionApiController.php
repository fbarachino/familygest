<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\Transaction;
use App\Modules\Economy\Requests\StoreTransactionRequest;
use App\Modules\Economy\Requests\UpdateTransactionRequest;
use Illuminate\Http\JsonResponse;

class EconomyTransactionApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Transaction::with(['accountType', 'category'])->orderByDesc('data')->get());
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create($request->validated());

        return response()->json($transaction, 201);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        $transaction->load(['accountType', 'category']);

        return response()->json($transaction);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        $transaction->update($request->validated());

        return response()->json($transaction);
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();

        return response()->json(null, 204);
    }
}
