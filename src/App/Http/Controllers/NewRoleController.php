<?php

namespace App\Http\Controllers;

use App\ViewModels\ModelMeViewModel;
use App\ViewModels\NewSystemRoleViewModel;
use Illuminate\Http\Request;
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

    public function apply($roleId)
    {
        $modelId = auth()->id();
        $data = $this->fetchRole($roleId, $modelId);

        if (!$data) {
            abort(404);
        }

        return Inertia::render('Roles/Listings/NewApply')
            ->with("viewModel", new NewSystemRoleViewModel($data, $modelId))
            ->with("meViewModel", new ModelMeViewModel(
                auth()->user()
                    ->load("portfolio")
                    ->load("digitals")
            ));
    }

    public function submitApplication($roleId, Request $request)
    {
        $modelId = auth()->id();

        $baseUrl = config('services.modelwise.api_url');
        if (!$baseUrl) {
            abort(500, 'New system not configured');
        }

        try {
            Http::timeout(10)->post("{$baseUrl}/api/roles/{$roleId}/apply", [
                'talent_id' => $modelId,
                'cover_letter' => $request->input('cover_letter'),
                'brand_conflicted' => $request->input('brand_conflicted'),
                'casting_questions' => $request->input('casting_questions'),
                'available_dates' => $request->input('available_dates'),
                'photo_paths' => $this->extractPhotoPaths($request->input('photos')),
                'casting_videos' => $this->extractVideoReferences($request->input('casting_videos')),
                'measurements' => [
                    'height' => $request->input('height'),
                    'chest' => $request->input('chest'),
                    'waist' => $request->input('waist'),
                    'hips' => $request->input('hips'),
                    'shoe_size' => $request->input('shoe_size'),
                    'clothing_size_top' => $request->input('clothing_size_top'),
                ],
            ]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => 'Failed to submit application. Please try again.']);
        }

        return redirect()->route("new-roles.show", $roleId);
    }

    public function togglePass($roleId)
    {
        $modelId = auth()->id();

        $baseUrl = config('services.modelwise.api_url');
        if (!$baseUrl) {
            abort(500, 'New system not configured');
        }

        try {
            Http::timeout(5)->post("{$baseUrl}/api/roles/{$roleId}/toggle-pass", [
                'talent_id' => $modelId,
            ]);
        } catch (\Exception) {
            // Silently fail — redirect back regardless
        }

        return redirect()->back();
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

    /**
     * Extract paths from photo data array (same format as old system's PhotoData).
     */
    private function extractPhotoPaths(?array $photos): ?array
    {
        if (empty($photos)) {
            return null;
        }

        return collect($photos)
            ->filter(fn ($photo) => !empty($photo['path']))
            ->pluck('path')
            ->values()
            ->all() ?: null;
    }

    /**
     * Map BaseFile[] from the frontend to a video reference shape the external API can use.
     * Direct-upload videos carry mux_upload_id; legacy R2 uploads carry path.
     *
     * @return array<int, array{mux_upload_id: ?string, path: ?string, mime: ?string}>|null
     */
    private function extractVideoReferences(?array $videos): ?array
    {
        if (empty($videos)) {
            return null;
        }

        return collect($videos)
            ->reject(fn ($v) => !empty($v['deleted']))
            ->map(fn ($v) => [
                'mux_upload_id' => $v['muxUploadId'] ?? null,
                'path' => !empty($v['path']) ? $v['path'] : null,
                'mime' => $v['mime'] ?? null,
            ])
            ->filter(fn ($v) => $v['mux_upload_id'] || $v['path'])
            ->values()
            ->all() ?: null;
    }
}
