<?php

namespace App\Http\Controllers\Model;

use Inertia\Inertia;

final class OnboardingController extends BaseOnboardingController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/Index");
    }

    public function firstApplication()
    {
        return redirect()->route('onboarding.thanks');
    }

    protected function nextOrReturn() {
        if (str_contains(request()->route()->uri, "onboarding")) {

            $steps = auth()->user()->onboarding()->steps();

            $currentStep = $steps->search(fn($step) => $step->link === request()->route()->uri);

            $nextStep = $steps->get($currentStep+1);

            if ($nextStep) return redirect()->to($nextStep->link);
        }

        return redirect()->route("account.index");
    }
}
