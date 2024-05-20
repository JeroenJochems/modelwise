<?php

namespace Support\Policies;

use Domain\Jobs\Models\Job;
use Illuminate\Contracts\Auth\Authenticatable;
use Support\User;
use function Pest\Laravel\instance;

class UserPolicy
{
    public function view(Authenticatable $authenticatable, User $user)
    {
        return $this->create($authenticatable);
    }

    public function create(Authenticatable $authenticatable)
    {
        return $authenticatable instanceof User && $authenticatable->email === "jeroen@joche.ms";
    }

    public function update(Authenticatable $authenticatable, User $user)
    {
        return $this->create($authenticatable);
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return $this->create($authenticatable);
    }

    public function uploadFiles(User $user): bool
    {
        return true;
    }
}
