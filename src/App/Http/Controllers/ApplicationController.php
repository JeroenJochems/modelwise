<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\RoleApplyViewModel;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Role;
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

    public function store(Role $role, PhotoRepository $photoRepository)
    {
        $application = Application::firstOrNew([
            'role_id' => $role->id,
            'model_id' => auth()->user()->id
        ]);

        $application->cover_letter = request()->get("cover_letter");
        $application->save();

        $photoRepository->update(auth()->user(), Photo::FOLDER_DIGITALS, request()->digitals);
        $photoRepository->update($application, Application::PHOTO_FOLDER, request()->photos);

        return Inertia::render('Applications/Stored')
            ->with("viewModel", new RoleApplyViewModel($role));
    }
}
