<?php

namespace Domain\Models\Policies;


use Domain\Models\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ModelPolicy
{
    public function view(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function delete(Authenticatable $authenticatable, Model $model)
    {
        return !$model->has_completed_onboarding;
    }

    public function update(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function addPhotos(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }

    public function uploadFiles(Model $model): bool
    {
        return true;
    }
}
