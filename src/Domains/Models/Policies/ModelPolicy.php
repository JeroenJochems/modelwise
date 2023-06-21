<?php

namespace Domain\Models\Policies;


use Domain\Models\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ModelPolicy
{
    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }

    public function uploadFiles(Model $model): bool
    {
        return true;
    }
}
