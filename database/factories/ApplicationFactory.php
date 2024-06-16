<?php

namespace Database\Factories;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'model_id' => fn() => Model::factory()->createOne()->id,
            'role_id' => fn() => Role::factory()->createOne()->id,
        ];
    }
}
