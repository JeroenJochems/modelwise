<?php

namespace App\ViewModels;

use Domain\Jobs\Models\Role;
use Domain\Models\Data\RoleData;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class RoleApplyViewModel extends ViewModel
{
    public RoleData $role;

    public function __construct(Role $role)
    {
        $this->role = RoleData::from(
            $role->load('job', 'job.look_and_feel_photos', 'photos', 'public_photos', 'job.brand', 'job.client'),
        );
    }
}
