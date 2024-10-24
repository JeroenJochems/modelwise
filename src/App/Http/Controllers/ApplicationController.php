<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\Apply;
use Domain\Work2\Actions\ExtendApplication;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct(
        public Apply $apply,
        public ExtendApplication $extendApplicationAction,
    ) {}

    public function create(Role $role)
    {
        return Inertia::render('Roles/Listings/Apply')
            ->with("viewModel", new ModelRoleViewModel($role))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()
                    ->load("portfolio")
                    ->load("digitals")
            ));
    }

    public function store(Role $role, Request $request)
    {
        $applyData = ApplyData::fromRequest($request->all());

        $this->apply->execute($request->user(), $role, $applyData);

        return redirect()->route("roles.show", $role);
    }

    public function update(Role $role, Request $request)
    {
        $listing = Listing::where("role_id", $role->id)
            ->where("model_id", auth()->id())
            ->first();

        $this->extendApplicationAction->execute(
            $listing,
            $request->get("casting_photos"),
            $request->get("casting_videos")
        );

        return Inertia::render('Roles/Listings/Updated')
            ->with("viewModel", new ModelRoleViewModel($listing->role, $listing));
    }
}
