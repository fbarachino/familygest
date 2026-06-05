<?php

namespace App\Modules;

interface ModuleInterface
{
    public function getName(): string;

    public function register(): void;

    public function boot(): void;

    /** @return DashboardWidget[] */
    public function getDashboardWidgets(): array;
}
