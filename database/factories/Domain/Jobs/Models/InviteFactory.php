<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class InviteFactory extends Factory
{
    protected $model = Invite::class;

    public function definition(): array
    {
        return [
            'model_id' => fn() => Model::factory()->createOne()->id,
            'role_id' => fn() => Role::factory()->createOne()->id,
        ];
    }
}
