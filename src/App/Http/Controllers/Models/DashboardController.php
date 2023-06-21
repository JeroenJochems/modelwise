<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke() {

        $model = auth()->user();

        if (!$model->has_completed_onboarding) {
            return redirect(route("onboarding.personal-details"));
        }

        if (is_null($model->is_accepted)) {
            return redirect(route("onboarding.thanks"));
        }

        if ($model->is_accepted===false) {
            return redirect(route("onboarding.not_accepted"));
        }

        return view(route("dashboard"));
    }
}
