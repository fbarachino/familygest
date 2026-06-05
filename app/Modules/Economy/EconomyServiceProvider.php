<?php

namespace App\Modules\Economy;

use App\Modules\DashboardWidget;
use App\Modules\Economy\Models\Category;
use App\Modules\Economy\Models\Transaction;
use App\Modules\ModuleInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EconomyServiceProvider extends ServiceProvider implements ModuleInterface
{
    public function getName(): string
    {
        return 'Economy';
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/Views', 'economy');

        Route::middleware('web')
            ->group(fn () => $this->loadRoutesFrom(__DIR__ . '/Routes/web.php'));
    }

    public function getDashboardWidgets(): array
    {
        $now = Carbon::now();

        return [
            new DashboardWidget(
                id: 'economy.monthly-income',
                title: 'Entrate del Mese',
                description: 'Totale entrate del mese corrente',
                icon: 'fas fa-arrow-up text-success',
                view: 'economy::dashboard.widgets.monthly-summary',
                width: 4,
                dataCallback: fn () => [
                    'total' => Transaction::whereHas('category', fn ($q) => $q->where('tipo', 'entrata'))
                        ->whereMonth('data', $now->month)
                        ->whereYear('data', $now->year)
                        ->sum('importo'),
                    'tipo' => 'entrata',
                ],
            ),
            new DashboardWidget(
                id: 'economy.monthly-expense',
                title: 'Spese del Mese',
                description: 'Totale spese del mese corrente',
                icon: 'fas fa-arrow-down text-danger',
                view: 'economy::dashboard.widgets.monthly-summary',
                width: 4,
                dataCallback: fn () => [
                    'total' => Transaction::whereHas('category', fn ($q) => $q->where('tipo', 'spesa'))
                        ->whereMonth('data', $now->month)
                        ->whereYear('data', $now->year)
                        ->sum('importo'),
                    'tipo' => 'spesa',
                ],
            ),
            new DashboardWidget(
                id: 'economy.monthly-balance',
                title: 'Bilancio Mensile',
                description: 'Differenza entrate - spese del mese',
                icon: 'fas fa-balance-scale',
                view: 'economy::dashboard.widgets.monthly-balance',
                width: 4,
                dataCallback: function () use ($now) {
                    $income = Transaction::whereHas('category', fn ($q) => $q->where('tipo', 'entrata'))
                        ->whereMonth('data', $now->month)
                        ->whereYear('data', $now->year)
                        ->sum('importo');
                    $expense = Transaction::whereHas('category', fn ($q) => $q->where('tipo', 'spesa'))
                        ->whereMonth('data', $now->month)
                        ->whereYear('data', $now->year)
                        ->sum('importo');
                    return [
                        'income' => $income,
                        'expense' => $expense,
                        'balance' => $income - $expense,
                    ];
                },
            ),
            new DashboardWidget(
                id: 'economy.recent-transactions',
                title: 'Ultimi Movimenti',
                description: 'Ultime 5 transazioni registrate',
                icon: 'fas fa-exchange-alt',
                view: 'economy::dashboard.widgets.recent-transactions',
                width: 12,
                dataCallback: fn () => [
                    'transactions' => Transaction::with(['category', 'accountType'])
                        ->latest()
                        ->take(5)
                        ->get(),
                ],
            ),
            new DashboardWidget(
                id: 'economy.categories-chart',
                title: 'Spese per Categoria',
                description: 'Distribuzione spese per categoria del mese',
                icon: 'fas fa-chart-pie',
                view: 'economy::dashboard.widgets.categories-chart',
                width: 6,
                dataCallback: function () use ($now) {
                    $data = Transaction::select('category_id', DB::raw('SUM(importo) as totale'))
                        ->whereHas('category', fn ($q) => $q->where('tipo', 'spesa'))
                        ->whereMonth('data', $now->month)
                        ->whereYear('data', $now->year)
                        ->groupBy('category_id')
                        ->orderByDesc('totale')
                        ->with('category')
                        ->get();
                    return ['categories' => $data];
                },
            ),
        ];
    }
}
