<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ModelController extends Controller
{
    public function index()
    {
        return Inertia::render("Account/Index");
    }

    public function subscribe()
    {
        $model = auth()->user();
        $model->is_subscribed_to_newsletter = true;
        $model->save();

        return redirect()->back();
    }

    public function thanks()
    {
        $recentlyViewedRole = auth()->user()->role_views()->first();

        if ($recentlyViewedRole) {
            return redirect()->route("applications.create", $recentlyViewedRole->role_id);
        }

        return Inertia::render("Model/Onboarding/Thanks")->with([
            'is_subscribed' => auth()->user()->is_subscribed_to_newsletter
        ]);
    }

    public function notAccepted()
    {
        return Inertia::render("Model/Onboarding/NotAccepted");
    }

}
