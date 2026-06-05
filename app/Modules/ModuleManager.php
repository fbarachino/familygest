<?php

namespace App\Modules;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ModuleManager
{
    protected Collection $modules;

    public function __construct()
    {
        $this->modules = collect();
    }

    public function register(ModuleInterface $module): void
    {
        $this->modules->put($module->getName(), $module);
        $module->register();
    }

    public function boot(): void
    {
        $this->modules->each(fn (ModuleInterface $module) => $module->boot());
    }

    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function getModule(string $name): ?ModuleInterface
    {
        return $this->modules->get($name);
    }

    public function isActive(string $name): bool
    {
        return $this->modules->has($name) && config("modules.{$name}.enabled", false);
    }

    public static function discover(): array
    {
        $modulesPath = app_path('Modules');
        $modules = [];

        if (!File::isDirectory($modulesPath)) {
            return $modules;
        }

        foreach (File::directories($modulesPath) as $dir) {
            $moduleName = basename($dir);
            $providerClass = "App\\Modules\\{$moduleName}\\{$moduleName}ServiceProvider";

            if (class_exists($providerClass)) {
                $modules[$moduleName] = [
                    'enabled' => config("modules.{$moduleName}.enabled", true),
                    'provider' => $providerClass,
                ];
            }
        }

        return $modules;
    }
}
