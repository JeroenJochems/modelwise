<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Domain\Models\Models\Model;

class DashboardController extends Controller
{
    public function submit()
    {
        dd("test");
    }

    public function __invoke()
    {
        /** @var Model $model */
        $model = auth()->user();

        if (!$model->is_onboarding_completed) {
            return view('livewire.models.onboarding')->layout('layouts.clean');
        }

        return view('livewire.models.dashboard');
    }
}
