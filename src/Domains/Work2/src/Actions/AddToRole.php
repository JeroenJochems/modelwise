<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;

class AddToRole
{
    public function execute(Role $role, Model $model): void
    {
        Listing::firstOrCreate([
            'role_id' => $role->id,
            'model_id' => $model->id,
        ]);
    }
}
