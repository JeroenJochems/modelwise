<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;

class DeleteListing
{
    public function execute(Role $role, Model $model): void
    {
        Listing::query()
            ->whereRoleId($role->id)
            ->whereModelId($model->id)
            ->whereNull('applied_at')
            ->whereNull('hired_at')
            ->delete();
    }
}
