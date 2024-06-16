<?php

namespace App\Http\Controllers;

use App\Mail\ClientSubmittedPreference;
use Domain\Jobs\Data\ApplicationData;
use Domain\Present\Models\Presentation;
use Domain\Work\Models\Application;
use Illuminate\Support\Facades\Mail;
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

    public function prelist(Presentation $presentation)
    {
        $prelist = request()->get("prelist");

        $applications = Application::whereIn('id', $presentation->applications)->get();
        $names = $applications->pluck('model.name');

        foreach ($applications as $application) {
            if ($application->prelisted_at && !in_array($application->id, $prelist)) {
                $application->prelisted_at = null;
            }

            if (!$application->prelisted_at && in_array($application->id, $prelist)) {
                $application->prelisted_at = now();
            }

            $application->save();
        }

        $role = $presentation->role;
        $role->load("job");

        Mail::to($role->job->responsible_user)
            ->send(new ClientSubmittedPreference($presentation, names: $names->toArray()));

        return Inertia::render('Roles/PrelistSubmitted')->with("role", $role);
    }
}
