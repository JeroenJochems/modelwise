<?php

namespace App\Http\Controllers\Model;

abstract class BaseOnboardingController
{
    protected function nextOrReturn() {
        if (str_contains(request()->route()->uri, "onboarding")) {

            $steps = auth()->user()->onboarding()->steps();

            $currentStep = $steps->search(fn($step) => str_contains(request()->route()->uri, $step->link));

            $nextStep = $steps->get($currentStep+1);

            if (!$nextStep) return redirect()->route("onboarding.thanks");

            return redirect()->to($nextStep->link);
        }

        return redirect()->route("account.index");
    }
}
