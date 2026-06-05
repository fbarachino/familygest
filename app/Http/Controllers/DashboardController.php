<?php

namespace App\Http\Controllers;

use App\Modules\DashboardManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardManager $dashboardManager
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $user = $request->user();

        $widgets = $this->dashboardManager->getUserWidgets($user);

        $widgetData = [];
        foreach ($widgets as $widget) {
            $widgetData[$widget->id] = $widget->getData();
        }

        return view('dashboard.index', [
            'widgets' => $widgets,
            'widgetData' => $widgetData,
        ]);
    }
}
