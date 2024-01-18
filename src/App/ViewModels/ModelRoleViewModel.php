<?php

namespace App\ViewModels;

use DateInterval;
use DatePeriod;
use Domain\Jobs\Data\ApplicationData;
use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Role;
use Spatie\ViewModels\ViewModel;

/** @typescript */
class ModelRoleViewModel extends ViewModel
{
    public RoleData $role;
    public bool $isInvited;
    public bool $hasApplied;
    public bool $hasPassed;
    public bool $isHired;
    public array $shootDates;
    public string $status;
    public ?ApplicationData $my_application;

    public function __construct(Role $role)
    {
        $role->load(
            'my_application',
            'my_application.hire',
            'my_application.photos',
            'my_application.casting_photos',
            'photos',
            'public_photos',
            'job',
            'job.look_and_feel_photos',
            'job.brand',
            'job.client',
            'my_passes',
            'my_invites',
        );

        $this->role = RoleData::from($role);

        $period = new DatePeriod(
            $role->start_date,
            new DateInterval('P1D'),
            $role->end_date ?? $role->start_date,
            DatePeriod::INCLUDE_END_DATE
        );

        $this->shootDates = [];
        foreach ($period as $date) {
            $this->shootDates[] = $date->format('Y-m-d');
        }

        $this->isInvited = $role->my_invites->count() > 0;
        $this->hasApplied = !!$role->my_application;

        $this->my_application = ($application = $role->my_application)
            ? ApplicationData::from($application)
            : null;

        $this->isHired = $role->my_applications->count()>0 && $role->my_applications->first()->hire()->count()>0;
        $this->hasPassed = !$this->hasApplied && $role->my_passes()->count() > 0;

        if ($this->isHired) {
            $this->status = "hired";
        } elseif ($this->hasPassed) {
            $this->status = "passed";
        } elseif ($this->isInvited) {
            $this->status = "invited";
        } elseif ($this->hasApplied) {
            $this->status = "applied";
        } else {
            $this->status = "open";
        }
    }
}
