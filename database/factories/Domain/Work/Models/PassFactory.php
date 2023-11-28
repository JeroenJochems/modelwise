<?php

namespace Database\Factories\Domain\Work\Models;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Pass;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassFactory extends Factory
{
    protected $model = Pass::class;

    public function definition(): array
    {
        return [
            'role_id' => fn() => Role::factory()->createOne()->id,
            'model_id' => fn() => Model::factory()->createOne()->id,
        ];
    }
}
