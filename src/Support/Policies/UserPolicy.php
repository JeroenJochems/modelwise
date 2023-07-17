<?php

namespace Support\Policies;

use Support\User;

class UserPolicy
{
    public function uploadFiles(User $user)
    {
        return true;
    }
}
