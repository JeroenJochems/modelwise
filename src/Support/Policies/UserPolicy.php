<?php

namespace Support\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Support\User;

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

    public function viewNova()
    {
        return true;

    }

    public function uploadFiles(User $user): bool
    {
        return true;
    }
}
