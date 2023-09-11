<?php

namespace App\ViewModels;

use Domain\Jobs\Data\ApplicationData;
use Domain\Jobs\Data\HireData;
use Domain\Jobs\Data\InviteData;
use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\Role;
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

        $this->openInvites = RoleData::collection(
            Role::query()
                ->withWhereHas("my_invites")
                ->whereDoesntHave("my_applications")
                ->with('photos', 'public_photos', 'job.look_and_feel_photos')
                ->get()
        );

        $this->openApplications = RoleData::collection(
            Role::query()
                ->withWhereHas("my_applications", function ($q) {
                    $q->whereDoesntHave("hire")
                      ->whereDoesntHave("rejection")
                      ->with('hire');
                })
                ->with('photos', 'public_photos', 'job.look_and_feel_photos')
                ->get()
        );

        $this->hires = RoleData::collection(
            Role::query()
                ->withWhereHas("my_invites")
                ->withWhereHas("my_applications", function ($q) {
                    $q->withWhereHas("hire");
                })
                ->with('photos', 'public_photos', 'job.look_and_feel_photos')
                ->get()
        );


        $recentlyViewed = $model->role_views()
            ->with("role", 'role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->orderByDesc('created_at')
            ->take(5)
            ->whereNotIn('role_id', collect($this->openApplications)->pluck('id'))
            ->whereNotIn('role_id', collect($this->hires)->pluck('id'))
            ->whereNotIn('role_id', collect($this->openInvites)->pluck('id'))
            ->get()
            ->pluck('role');

        $this->recentlyViewedRoles = RoleData::collection($recentlyViewed);

    }
}
