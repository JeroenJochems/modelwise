<?php

namespace App\ViewModels;

use DateInterval;
use DatePeriod;
use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Role;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class RoleApplyViewModel extends ViewModel
{
    public RoleData $role;
    public bool $isInvited;
    public bool $hasApplied;
    public array $shootDates;
    public array $viewedRoles;

    public function __construct(Role $role)
    {
        $role->load('my_applications.hire', 'my_invites', 'job', 'job.look_and_feel_photos', 'photos', 'public_photos', 'job.brand', 'job.client');

        $this->role = RoleData::from($role);

        $period = new DatePeriod(
            $role->start_date,
            new DateInterval('P1D'),
            $role->end_date ?? $role->start_date,
            DatePeriod::INCLUDE_END_DATE
        );

        $this->viewedRoles = request()->session()->get('viewed_roles', []);

        $this->shootDates = [];
        foreach ($period as $date) {
            $this->shootDates[] = $date->format('Y-m-d');
        }

        $this->isInvited = $role->my_invites->count() > 0;
        $this->hasApplied = $role->my_applications->count() > 0;
    }
}
