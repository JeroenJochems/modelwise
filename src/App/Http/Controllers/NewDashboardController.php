<?php

namespace App\Http\Controllers;

use App\ViewModels\NewDashboardViewModel;
use Inertia\Inertia;
use Laravel\Nova\Contracts\ImpersonatesUsers;

class NewDashboardController extends Controller
{
    public function __invoke() {

        $impersonator = app()->make(ImpersonatesUsers::class);

        if (!$impersonator->impersonating(request())) {
            return redirect()->route('dashboard');
        }

        $model = auth()->user();

        $vm = new NewDashboardViewModel($model);

        return Inertia::render("NewDashboard")
            ->with('vm', $vm);
    }
}
