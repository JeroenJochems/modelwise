<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Role;
use Inertia\Inertia;

class RoleProposalController extends Controller
{
    public function show(Role $role)
    {
        $role->load("applications.model.digitals", "applications.casting_photos", "applications.photos", "applications.casting_videos", "applications.model.photos", "job");

        return Inertia::render('Roles/Proposal')
            ->with("role", $role);
    }
}
