<?php

namespace App\Http\Controllers;

use App\ViewModels\RoleApplyViewModel;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function show(Role $role)
    {
        return Inertia::render('Roles/Show')
            ->with("viewModel", new RoleApplyViewModel($role));
    }
}