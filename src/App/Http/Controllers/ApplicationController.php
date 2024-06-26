<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Repositories\PhotoRepository;
use Domain\Profiles\Repositories\VideoRepository;
use Domain\Work\Models\Application;
use Domain\Work2\Actions\Apply;
use Domain\Work2\Actions\ExtendApplication;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function create(Role $role)
    {
        return Inertia::render('Roles/Listings/Apply')
            ->with("viewModel", new ModelRoleViewModel($role))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()
                    ->load("digitals")
            ));
    }

    public function store(Role $role, Request $request)
    {
        $model = auth()->user();
        if (!($model instanceof Model)) abort(403, "You are not a model");

        $data = ApplyData::fromRequest($request->all());

        app()->make(Apply::class)($model, $role, $data);

        return redirect()->route("roles.show", $role);
    }

    public function update(Role $role, Request $request)
    {
        $listing = Listing::where("role_id", $role->id)
            ->where("model_id", auth()->id())
            ->first();

        app()->make(ExtendApplication::class)(
            $listing,
            $request->get("casting_photos"),
            $request->get("casting_videos")
        );

        return Inertia::render('Roles/Listings/Updated')
            ->with("viewModel", new ModelRoleViewModel($listing->role, $listing));
    }
}
