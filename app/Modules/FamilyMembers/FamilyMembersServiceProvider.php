<?php

namespace App\Modules\FamilyMembers;

use App\Modules\DashboardWidget;
use App\Modules\FamilyMembers\Models\FamilyMember;
use App\Modules\ModuleInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class FamilyMembersServiceProvider extends ServiceProvider implements ModuleInterface
{
    public function getName(): string
    {
        return 'FamilyMembers';
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/Views', 'family-members');

        \Illuminate\Support\Facades\Route::middleware('web')
            ->group(fn () => $this->loadRoutesFrom(__DIR__ . '/Routes/web.php'));
    }

    public function getDashboardWidgets(): array
    {
        return [
            new DashboardWidget(
                id: 'family-members.total',
                title: 'Membri della Famiglia',
                description: 'Numero totale di membri registrati',
                icon: 'fas fa-users',
                view: 'family-members::dashboard.widgets.total-members',
                width: 4,
                dataCallback: fn () => [
                    'total' => FamilyMember::count(),
                    'new_this_month' => FamilyMember::whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->count(),
                ],
            ),
        ];
    }
}
