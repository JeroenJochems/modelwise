<?php

namespace Domain\Work2\Policies;

use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ListingPolicy
{
    public function view(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function create(Authenticatable $authenticatable)
    {
        return true;
    }

    public function update(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function addPhotos(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function addPhoto(Authenticatable $authenticatable, Model $model)
    {
        return true;
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }

    public function viewNova(Authenticatable $authenticatable)
    {
        return false;
    }

    public function uploadFiles(Model $model): bool
    {
        return true;
    }
}
