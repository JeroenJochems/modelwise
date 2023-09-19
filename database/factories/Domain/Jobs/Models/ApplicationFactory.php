<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        return [
            'role_id' => Role::factory()->createOne()->id,
            'model_id' => Model::factory()->createOne()->id,
            'cover_letter' => $this->faker->realText,
        ];
    }
}
