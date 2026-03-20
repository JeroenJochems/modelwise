<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelRoleViewModel;
use App\ViewModels\NewSystemRoleViewModel;
use Domain\Jobs\Models\Role;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return redirect()->to("/dashboard");
    }

    public function show($roleId)
    {
        $role = Role::find($roleId);

        if ($role) {
            return $this->showOldSystemRole($role);
        }

        return $this->showNewSystemRole($roleId);
    }

    private function showOldSystemRole(Role $role)
    {
        $modelId = auth()->id();
        Session::put('viewed_roles', array_unique([$role->id, ...Session::get('viewed_roles', [])]));

        $listing = $role->listings()->where('model_id', $modelId)->first();
        $pass = $role->passes()->where('model_id', $modelId)->first();

        return Inertia::render('Roles/Show')
            ->with("viewModel", new ModelRoleViewModel($role, $listing, $pass));
    }

    private function showNewSystemRole($roleId)
    {
        $modelId = auth()->id();
        $data = $this->fetchNewSystemRole($roleId, $modelId);

        if (!$data) {
            abort(404);
        }

        Session::put('viewed_roles', array_unique([(int) $roleId, ...Session::get('viewed_roles', [])]));

        return Inertia::render('Roles/Show')
            ->with("viewModel", new NewSystemRoleViewModel($data, $modelId));
    }

    private function fetchNewSystemRole(int|string $roleId, int|string $talentId): ?array
    {
        $baseUrl = config('services.modelwise.api_url');
        if (!$baseUrl) {
            return null;
        }

        try {
            $response = Http::timeout(5)
                ->get("{$baseUrl}/api/roles/{$roleId}", ['talent_id' => $talentId]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception) {
            return null;
        }
    }
}
