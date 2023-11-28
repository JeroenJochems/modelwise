<?php

namespace Domain\Work\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;

class Pass
{
    public function __invoke(Model $model, Role $role)
    {
        $pass = new \Domain\Work\Models\Pass();
        $pass->model_id = $model->id;
        $pass->role_id = $role->id;
        $pass->save();

        return $pass;
    }
}
