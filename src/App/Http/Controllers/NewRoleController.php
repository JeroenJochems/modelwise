<?php

namespace App\Http\Controllers;

use App\ViewModels\NewSystemRoleViewModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class NewRoleController extends Controller
{
    public function show($roleId)
    {
        $modelId = auth()->id();
        $data = $this->fetchRole($roleId, $modelId);

        if (!$data) {
            abort(404);
        }

        Session::put('viewed_roles', array_unique([(int) $roleId, ...Session::get('viewed_roles', [])]));

        return Inertia::render('Roles/NewShow')
            ->with("viewModel", new NewSystemRoleViewModel($data, $modelId));
    }

    private function fetchRole(int|string $roleId, int|string $talentId): ?array
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
