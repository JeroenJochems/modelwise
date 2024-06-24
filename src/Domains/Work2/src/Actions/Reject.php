<?php

namespace Domain\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\RoleId;
use Domain\Work2\RoleRepository;

class Reject
{
    public function __construct(private readonly RoleRepository $repo) {}


    public function execute(Role $role, Model $model, string $subject, string $message)
    {
        $agg = $this->repo->retrieve(RoleId::fromString($role->id));
        $agg->reject($model, $subject, $message);

        $this->repo->persist($agg);
    }
}
