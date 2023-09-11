<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\RoleApplyViewModel;
use Domain\Jobs\Actions\Apply;
use Domain\Jobs\Data\ApplyData;
use Domain\Jobs\Models\Role;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index()
    {
        return redirect()->to("/dashboard");
    }

    public function create(Role $role)
    {
        return Inertia::render('Applications/Create')
            ->with("viewModel", new RoleApplyViewModel($role))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()
                    ->load("digitals")
                    ->load("portfolio")
            ));
    }

    public function store(Role $role, ApplyData $data)
    {
        app(Apply::class)($data);

        return Inertia::render('Applications/Stored')
            ->with("viewModel", new RoleApplyViewModel($role));
    }
}
