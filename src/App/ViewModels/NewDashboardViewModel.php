<?php

namespace App\ViewModels;

use Domain\Jobs\Data\ListingData;
use Domain\Jobs\Data\RoleData;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Pass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class NewDashboardViewModel extends ViewModel
{
    /** @var array<ListingData> */
    public Collection $listings;

    /** @var array<RoleData> */
    public Collection $recentlyViewedRoles;

    public ?ModelData $model;

    /** @var Array<int>  */
    public array $passedRoles;

    public function __construct(Model|Authenticatable $model){

        $this->model = ModelData::from($model);

        $newSystemData = $this->fetchNewSystemDashboard($model->id);
        if ($newSystemData) {
            $modelArray = $this->model->toArray();
            $this->listings = collect($newSystemData['listings'])
                ->map(function ($item) use ($modelArray) {
                    $item['model'] = $modelArray;
                    return ListingData::from($item);
                });
        } else {
            $this->listings = collect();
        }

        $recentlyViewed = $model->role_views()
            ->with("role",'role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->orderByDesc('created_at')
            ->take(5)
            ->whereNotIn('role_id', collect($this->listings)->pluck('role_id'))
            ->get()
            ->pluck('role');

        $this->recentlyViewedRoles = RoleData::collect($recentlyViewed->filter(fn($role) => $role->is_active));

        $this->passedRoles = Pass::whereModelId($model->id)->pluck('role_id')->toArray();
    }

    private function fetchNewSystemDashboard(int $talentId): ?array
    {
        $baseUrl = config('services.modelwise.api_url');
        if (!$baseUrl) {
            return null;
        }

        try {
            $response = Http::timeout(5)
                ->get("{$baseUrl}/api/talent/{$talentId}/dashboard");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception) {
            return null;
        }
    }
}
