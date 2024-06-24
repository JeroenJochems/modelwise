<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\RoleId;
use Domain\Work2\RoleRepository;

class AddToRole
{
    public function __construct(private readonly RoleRepository $roleRepository)
    {}

    public function execute(Role $role, Model $model): void
    {
        $roleAggregate = $this->roleRepository->retrieve(RoleId::fromString($role->id));
        $roleAggregate->add($model);

        $this->roleRepository->persist($roleAggregate);
    }
}
