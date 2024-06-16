<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Models\Role;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function show(Role $role)
    {
        Session::put('viewed_roles', array_unique([$role->id, ...Session::get('viewed_roles', [])]));

        $application = $role->applications->firstWhere('model_id', auth()->id());

        if ($application && $application->photos()->count()===0) {
            return redirect()->route('roles.apply', $role->id);
        }

        return Inertia::render('Roles/Show')
            ->with("viewModel", new ModelRoleViewModel($role));
    }
}
