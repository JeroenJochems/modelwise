<?php

namespace App\ViewModels;

use Domain\Jobs\Data\ApplicationData;
use Domain\Jobs\Data\HireData;
use Domain\Jobs\Data\ListingData;
use Domain\Jobs\Data\RoleData;
use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelData\DataCollection;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class DashboardViewModel extends ViewModel
{
    /* @var DataCollection|array<RoleData> */
    public $openInvites;

    /* @var DataCollection|array<ApplicationData> */
    public $openApplications;

    /* @var DataCollection|array<RoleData> */
    public $recentlyViewedRoles;

    /* @var DataCollection|array<HireData> */
    public $hires;

    public function __construct(public Model|Authenticatable $model){

        $listings = $model->listings()
            ->whereNull('rejected_at')
            ->with("role", 'role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->get();

        $this->listings = ListingData::collection($listings);

        $recentlyViewed = $model->role_views()
            ->with("role",'role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->whereRelation("role", "end_date", ">", now())
            ->orderByDesc('created_at')
            ->take(5)
            ->whereNotIn('role_id', collect($this->listings)->pluck('role_id'))
            ->get()
            ->pluck('role');

        $this->recentlyViewedRoles = RoleData::collection($recentlyViewed);
    }
}
