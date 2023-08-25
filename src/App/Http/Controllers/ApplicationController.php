<?php

namespace App\Http\Controllers;

use App\Nova\Invite;
use App\ViewModels\ModelMeViewModel;
use App\ViewModels\RoleApplyViewModel;
use Domain\Jobs\Actions\Apply;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index()
    {
        return Inertia::render('Applications/Index')
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()->load([
                    "applications.role.photos",
                    "applications.role.public_photos",
                    "applications.role.job",
                    "applications.role.job.look_and_feel_photos",
                ])
            ));
    }

    public function create(Role $role)
    {
        return Inertia::render('Applications/Create')
            ->with("viewModel", new RoleApplyViewModel($role))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()->load("digitals")
            ));
    }

    public function store(Role $role)
    {
        (new Apply)(auth()->user(), $role);

        return Inertia::render('Applications/Stored')
            ->with("viewModel", new RoleApplyViewModel($role));
    }
}
