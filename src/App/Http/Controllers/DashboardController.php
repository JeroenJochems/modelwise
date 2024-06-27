<?php

namespace App\Http\Controllers;

use App\ViewModels\DashboardViewModel;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke() {

        $model = auth()->user();

        $vm = new DashboardViewModel($model);

        return Inertia::render("Dashboard")
            ->with('vm', $vm);
    }
}
