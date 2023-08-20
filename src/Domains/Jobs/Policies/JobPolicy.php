<?php

namespace Domain\Jobs\Policies;


use Domain\Jobs\Models\Job;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class JobPolicy
{
    use HandlesAuthorization;

    public function view(Authenticatable $authenticatable, Job $job)
    {
        return true;
    }

    public function create(Authenticatable $authenticatable)
    {
        return true;
    }

    public function update(Authenticatable $authenticatable, Job $job)
    {
        return true;
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }

    public function uploadFiles(Job $job): bool
    {
        return true;
    }

    public function addPhotos(Authenticatable $authenticatable, Job $job)
    {
        return true;
    }

    public function addPhoto(Authenticatable $authenticatable, Job $job)
    {
        return true;
    }
    public function attachAnyPhoto(Authenticatable $authenticatable, Job $job)
    {
        return true;
    }
}
