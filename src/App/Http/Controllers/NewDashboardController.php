<?php

namespace App\Http\Controllers;

use App\ViewModels\NewDashboardViewModel;
use Inertia\Inertia;

class NewDashboardController extends Controller
{
    public function __invoke() {

        $model = auth()->user();

        $vm = new NewDashboardViewModel($model);

        return Inertia::render("NewDashboard")
            ->with('vm', $vm);
    }
}
