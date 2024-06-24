<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\RoleId;
use Domain\Work2\RoleRepository;

class Apply
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
    )
    {}

    public function __invoke(Model $model, Role $role, ApplyData $data): void
    {
        $roleAggregate = $this->roleRepository->retrieve(RoleId::fromString($role->id));
        $roleAggregate->submitApplication($model, $data);

        $this->roleRepository->persist($roleAggregate);
    }
}
