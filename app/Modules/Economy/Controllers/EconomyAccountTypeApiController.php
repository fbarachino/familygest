<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\AccountType;
use App\Modules\Economy\Requests\StoreAccountTypeRequest;
use App\Modules\Economy\Requests\UpdateAccountTypeRequest;
use Illuminate\Http\JsonResponse;

class EconomyAccountTypeApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(AccountType::orderBy('nome')->get());
    }

    public function store(StoreAccountTypeRequest $request): JsonResponse
    {
        $accountType = AccountType::create($request->validated());

        return response()->json($accountType, 201);
    }

    public function show(AccountType $accountType): JsonResponse
    {
        $accountType->load('transactions');

        return response()->json($accountType);
    }

    public function update(UpdateAccountTypeRequest $request, AccountType $accountType): JsonResponse
    {
        $accountType->update($request->validated());

        return response()->json($accountType);
    }

    public function destroy(AccountType $accountType): JsonResponse
    {
        $accountType->delete();

        return response()->json(null, 204);
    }
}
