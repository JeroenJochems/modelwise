<?php

namespace App\ViewModels;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Data\RoleData;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class RoleApplyViewModel extends ViewModel
{
    public RoleData $role;
    public bool $isInvited;

    public function __construct(Role $role)
    {
        $this->isInvited = $role->invites()->where('model_id', auth()->id())->count() > 0;

        $this->hasApplied = $role->applications()->where('model_id', auth()->id())->count() > 0;

        $this->role = RoleData::from(
            $role->load('job', 'job.look_and_feel_photos', 'photos', 'public_photos', 'job.brand', 'job.client'),
        );
    }
}
