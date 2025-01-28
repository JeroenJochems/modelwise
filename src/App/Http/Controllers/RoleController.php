<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Models\Role;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return redirect()->to("/dashboard");
    }

    public function show(Role $role)
    {
        $modelId = auth()->id();
        Session::put('viewed_roles', array_unique([$role->id, ...Session::get('viewed_roles', [])]));

        $listing = $role->listings()->where('model_id', $modelId)->first();
        $pass = $role->passes()->where('model_id', $modelId)->first();

        return Inertia::render('Roles/Show')
            ->with("viewModel", new ModelRoleViewModel($role, $listing, $pass));
    }
}
