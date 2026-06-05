<?php

namespace App\Modules\FamilyMembers;

use App\Modules\ModuleInterface;
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

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
