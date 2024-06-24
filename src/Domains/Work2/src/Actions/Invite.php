<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\RoleId;
use Domain\Work2\RoleRepository;

class Invite
{
    public function __construct(private readonly RoleRepository $repo)
    {}

    public function execute(Role $role, Model $model): void
    {
        $roleAggregate = $this->repo->retrieve(RoleId::fromString($role->id));
        $roleAggregate->invite($model);

        $this->repo->persist($roleAggregate);
    }
}
