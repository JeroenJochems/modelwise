<?php

namespace App\Http\Controllers\Model;

use Inertia\Inertia;

class OnboardingController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/Index");
    }
}
