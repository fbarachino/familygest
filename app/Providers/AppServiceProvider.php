<?php

namespace App\Providers;

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
    }

    public function boot(): void
    {
        $manager = $this->app->make(ModuleManager::class);

        $manager->register(
            new FamilyMembersServiceProvider($this->app)
        );

        $manager->boot();
    }
}
