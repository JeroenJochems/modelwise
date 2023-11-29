<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Models\Role;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function show(Role $role)
    {
        Session::put('viewed_roles', array_unique([$role->id, ...Session::get('viewed_roles', [])]));

        return Inertia::render('Roles/Show')
            ->with("viewModel", new ModelRoleViewModel($role));
    }
}
