<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Data\ApplyData;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Repositories\PhotoRepository;
use Domain\Profiles\Repositories\VideoRepository;
use Domain\Work\Actions\Apply;
use Domain\Work\Models\Application;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index()
    {
        return redirect()->to("/dashboard");
    }

    public function show(Application $application)
    {
        return Inertia::render('Roles/Show')
            ->with("viewModel", new ModelRoleViewModel($application->role));
    }

    public function create(Role $role)
    {
        return Inertia::render('Applications/Create')
            ->with("viewModel", new ModelRoleViewModel($role))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()
                    ->load("digitals")
            ));
    }


    public function store(Role $role, ApplyData $data)
    {
        try {
            app(Apply::class)($data);
        } catch (\Exception $e) {
            if (str_contains(strtolower($e->getMessage()), 'duplicate')) {
                return redirect()->route("roles.show", $role)->with("error", "You have already applied for this role.");
            }

            throw $e;
        }

        return redirect()->route("roles.show", $role);
    }

    public function update(Application $application)
    {
        if ($videos = request()->get("casting_videos")) {
            app(VideoRepository::class)->update($application, Application::CASTING_VIDEOS, $videos);
        }

        if ($photos = request()->get("casting_photos")) {
            app(PhotoRepository::class)->update($application, Application::CASTING_PHOTO_FOLDER, $photos);
        }

        return Inertia::render('Applications/Updated')
            ->with("viewModel", new ModelRoleViewModel($application->role));
    }
}
