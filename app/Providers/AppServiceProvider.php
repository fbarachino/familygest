<?php

namespace App\Providers;

use App\Modules\DashboardManager;
use App\Modules\Economy\EconomyServiceProvider;
use App\Modules\FamilyMembers\FamilyMembersServiceProvider;
use App\Modules\ModuleManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleManager::class, function () {
            return new ModuleManager;
        });

        $this->app->singleton(DashboardManager::class, function () {
            return new DashboardManager;
        });
    }

    public function boot(): void
    {
        $manager = $this->app->make(ModuleManager::class);
        $dashboard = $this->app->make(DashboardManager::class);

        $modules = [
            new FamilyMembersServiceProvider($this->app),
            new EconomyServiceProvider($this->app),
        ];

        foreach ($modules as $module) {
            $manager->register($module);
            $dashboard->registerModuleWidgets($module);
        }

        $manager->boot();
    }
}
