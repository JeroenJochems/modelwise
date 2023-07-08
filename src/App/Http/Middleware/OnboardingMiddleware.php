<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class OnboardingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $model = auth()->user();

        if (!$model->has_completed_onboarding) {

            if ($request->route()->getName() !== "onboarding.personal-details") {
                return redirect(route("onboarding.personal-details"));
            }
        }

        if ($model->has_completed_onboarding && !$model->is_accepted) {
            if ($request->route()->getName() !== "onboarding.thanks") {
                return redirect(route("onboarding.thanks"));
            }
        }

        return $next($request);
    }
}
