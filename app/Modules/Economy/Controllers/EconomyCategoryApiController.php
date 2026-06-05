<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\Category;
use App\Modules\Economy\Requests\StoreCategoryRequest;
use App\Modules\Economy\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class EconomyCategoryApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Category::orderBy('tipo')->orderBy('nome')->get());
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load('transactions');

        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
