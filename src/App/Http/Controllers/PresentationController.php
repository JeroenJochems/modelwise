<?php

namespace App\Http\Controllers;

use Domain\Jobs\Data\ApplicationData;
use Domain\Present\Models\Presentation;
use Domain\Work\Models\Application;
use Inertia\Inertia;

class PresentationController extends Controller
{
    public function show(Presentation $presentation)
    {
        $role = $presentation->role;
        $role->load("job");
        $applications = Application::whereIn("id", $presentation->applications)->orderBy('order_column')->get();
        $applications->load("model.digitals", "casting_photos", "photos", "casting_videos", "model.portfolio");

        return Inertia::render('Roles/Proposal')
            ->with("role", $role)
            ->with("presentation", $presentation)
            ->with("applications", ApplicationData::collection($applications));
    }

    public function shortlist(Presentation $presentation)
    {
        foreach (Application::whereIn('id', request()->get("applications"))->get() as $application) {
            $application->shortlisted_at = $application->shortlisted_at ? null : now();
            $application->save();
        }

        return "Ok";
    }
}
