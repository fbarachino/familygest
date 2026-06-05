<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\Category;
use App\Modules\Economy\Requests\StoreCategoryRequest;
use App\Modules\Economy\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EconomyCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('tipo')->orderBy('nome')->paginate(15);

        return view('economy::categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('economy::categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('economy.categories.index')
            ->with('success', 'Categoria creata con successo.');
    }

    public function show(Category $category): View
    {
        $category->load('transactions');

        return view('economy::categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('economy::categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('economy.categories.index')
            ->with('success', 'Categoria aggiornata con successo.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('economy.categories.index')
            ->with('success', 'Categoria eliminata con successo.');
    }
}
