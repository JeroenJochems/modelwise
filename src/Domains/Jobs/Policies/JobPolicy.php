<?php

namespace Domain\Jobs\Policies;


use Domain\Jobs\Models\Job;
use Domain\Models\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class JobPolicy
{
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
}
