<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke() {

        $model = auth()->user();

        return Inertia::render("Dashboard");
    }
}
