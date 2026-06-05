<?php

namespace App\Modules;

use App\Models\User;
use Illuminate\Support\Collection;

class DashboardManager
{
    private Collection $widgets;

    public function __construct()
    {
        $this->widgets = collect();
    }

    public function registerModuleWidgets(ModuleInterface $module): void
    {
        foreach ($module->getDashboardWidgets() as $widget) {
            $this->widgets->put($widget->id, $widget);
        }
    }

    /** @return DashboardWidget[] */
    public function getAvailableWidgets(): array
    {
        return $this->widgets->all();
    }

    public function getWidget(string $id): ?DashboardWidget
    {
        return $this->widgets->get($id);
    }

    public function getUserWidgets(User $user): Collection
    {
        $prefs = $user->dashboardPreferences()
            ->pluck('enabled', 'widget_id')
            ->toArray();

        return $this->widgets
            ->filter(fn (DashboardWidget $w) => $prefs[$w->id] ?? $w->enabledByDefault)
            ->sortBy(fn (DashboardWidget $w) => $this->getUserOrder($user, $w->id))
            ->values();
    }

    public function getAllEnabledWidgets(): Collection
    {
        return $this->widgets
            ->where('enabledByDefault', true)
            ->values();
    }

    public function syncUserPreferences(User $user, array $preferences): void
    {
        $user->dashboardPreferences()->delete();

        $data = [];
        foreach ($preferences as $i => $pref) {
            $data[] = [
                'user_id' => $user->id,
                'widget_id' => $pref['widget_id'],
                'enabled' => filter_var($pref['enabled'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'order' => $i,
                'column_width' => $pref['column_width'] ?? null,
            ];
        }

        $user->dashboardPreferences()->insert($data);
    }

    private function getUserOrder(User $user, string $widgetId): int
    {
        static $orders = [];

        if (empty($orders)) {
            $orders = $user->dashboardPreferences()
                ->pluck('order', 'widget_id')
                ->toArray();
        }

        return $orders[$widgetId] ?? 0;
    }
}
