<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke() {
        return redirect(route('onboarding.personal-details'));
    }
}
