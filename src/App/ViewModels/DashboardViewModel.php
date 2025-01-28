<?php

namespace App\ViewModels;

use Domain\Jobs\Data\ListingData;
use Domain\Jobs\Data\RoleData;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Pass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class DashboardViewModel extends ViewModel
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

        $listings = $model->listings()
            ->whereNull('rejected_at')
            ->where(function($q) {
                $q
                    ->whereRelation("role", "end_date", ">", now())
                    ->orWhereHas("role", function($q) {
                        $q->whereNull("end_date");
                    })
                    ->orWhereNotNull('hired_at');
            })
            ->with(["model", "role.job", "photos", "casting_photos", "casting_videos"])
            ->get();

        $this->listings = ListingData::collect($listings);

        $recentlyViewed = $model->role_views()
            ->with("role",'role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->orderByDesc('created_at')
            ->take(5)
            ->whereNotIn('role_id', collect($this->listings)->pluck('role_id'))
            ->get()
            ->pluck('role');

        $this->recentlyViewedRoles = RoleData::collect($recentlyViewed);

        $this->passedRoles = Pass::whereModelId($model->id)->pluck('role_id')->toArray();
    }
}
