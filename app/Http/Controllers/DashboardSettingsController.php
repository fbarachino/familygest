<?php

namespace App\Http\Controllers;

use App\Modules\DashboardManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardSettingsController extends Controller
{
    public function __construct(
        protected DashboardManager $dashboardManager
    ) {
        $this->middleware('auth');
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        $widgets = $this->dashboardManager->getAvailableWidgets();

        $prefs = $user->dashboardPreferences()
            ->pluck('enabled', 'widget_id')
            ->toArray();

        $widgetPrefs = [];
        foreach ($widgets as $widget) {
            $widgetPrefs[$widget->id] = [
                'widget' => $widget,
                'enabled' => $prefs[$widget->id] ?? $widget->enabledByDefault,
            ];
        }

        return view('dashboard.settings', [
            'widgetPrefs' => $widgetPrefs,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'widgets' => 'required|array',
            'widgets.*.widget_id' => 'required|string',
            'widgets.*.enabled' => 'nullable|boolean',
            'widgets.*.column_width' => 'nullable|integer|min:1|max:12',
        ]);

        $this->dashboardManager->syncUserPreferences(
            $request->user(),
            $validated['widgets']
        );

        return redirect()
            ->route('dashboard')
            ->with('success', 'Impostazioni dashboard salvate con successo.');
    }
}
