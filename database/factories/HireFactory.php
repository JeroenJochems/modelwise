<?php

namespace Database\Factories;

use Domain\Work\Models\Application;
use Domain\Work\Models\Hire;
use Illuminate\Database\Eloquent\Factories\Factory;

class HireFactory extends Factory
{
    protected $model = Hire::class;

    public function definition(): array
    {
        return [
            'application_id' => fn() => Application::factory()->createOne()->id,
        ];
    }
}
