<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\AccountType;
use App\Modules\Economy\Requests\StoreAccountTypeRequest;
use App\Modules\Economy\Requests\UpdateAccountTypeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EconomyAccountTypeController extends Controller
{
    public function index(): View
    {
        $accountTypes = AccountType::orderBy('nome')->paginate(15);

        return view('economy::account_types.index', compact('accountTypes'));
    }

    public function create(): View
    {
        return view('economy::account_types.create');
    }

    public function store(StoreAccountTypeRequest $request): RedirectResponse
    {
        AccountType::create($request->validated());

        return redirect()->route('economy.account-types.index')
            ->with('success', 'Tipo conto creato con successo.');
    }

    public function show(AccountType $accountType): View
    {
        $accountType->load('transactions');

        return view('economy::account_types.show', compact('accountType'));
    }

    public function edit(AccountType $accountType): View
    {
        return view('economy::account_types.edit', compact('accountType'));
    }

    public function update(UpdateAccountTypeRequest $request, AccountType $accountType): RedirectResponse
    {
        $accountType->update($request->validated());

        return redirect()->route('economy.account-types.index')
            ->with('success', 'Tipo conto aggiornato con successo.');
    }

    public function destroy(AccountType $accountType): RedirectResponse
    {
        $accountType->delete();

        return redirect()->route('economy.account-types.index')
            ->with('success', 'Tipo conto eliminato con successo.');
    }
}
