<?php

namespace App\Http\Middleware;

use Closure;

class OnboardingMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->onboarding()->inProgress()) {
            return redirect()->to(
                auth()->user()->onboarding()->nextUnfinishedStep()->link
            );
        }

        return $next($request);
    }
}
