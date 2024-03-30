<?php

namespace Support\Policies;

use Support\User;

class UserPolicy
{
    public function uploadFiles(User $user): bool
    {
        ray("test");
        return true;
    }
}
