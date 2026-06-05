<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\AccountType;
use App\Modules\Economy\Models\Category;
use App\Modules\Economy\Models\Transaction;
use App\Modules\Economy\Requests\StoreTransactionRequest;
use App\Modules\Economy\Requests\UpdateTransactionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EconomyTransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with(['accountType', 'category'])
            ->orderByDesc('data')
            ->paginate(20);

        return view('economy::transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $accountTypes = AccountType::orderBy('nome')->pluck('nome', 'id');
        $categories = Category::orderBy('tipo')->orderBy('nome')->pluck('nome', 'id');

        return view('economy::transactions.create', compact('accountTypes', 'categories'));
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Transaction::create($request->validated());

        return redirect()->route('economy.transactions.index')
            ->with('success', 'Movimento registrato con successo.');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['accountType', 'category']);

        return view('economy::transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction): View
    {
        $accountTypes = AccountType::orderBy('nome')->pluck('nome', 'id');
        $categories = Category::orderBy('tipo')->orderBy('nome')->pluck('nome', 'id');

        return view('economy::transactions.edit', compact('transaction', 'accountTypes', 'categories'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $transaction->update($request->validated());

        return redirect()->route('economy.transactions.index')
            ->with('success', 'Movimento aggiornato con successo.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('economy.transactions.index')
            ->with('success', 'Movimento eliminato con successo.');
    }
}
