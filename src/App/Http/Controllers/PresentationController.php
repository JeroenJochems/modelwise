<?php

namespace App\Http\Controllers;

use App\Mail\ClientSubmittedPreference;
use Domain\Present\Models\Presentation;
use Domain\Work\Models\Application;
use Domain\Work2\Data\ModelRoleData;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PresentationController extends Controller
{
    public function show(Presentation $presentation)
    {
        $role = $presentation->role;
        $role->load("job");

        $modelRoles = ModelRoleData::collection(
            Listing::query()
                ->whereIn("id", $presentation->model_roles)
                ->orderBy('order_column')
                ->with("model.digitals", "casting_videos", "model.portfolio")
                ->get()
        );

        return Inertia::render('Roles/Proposal')
            ->with("role", $role)
            ->with("presentation", $presentation)
            ->with("modelRoles", $modelRoles);
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
