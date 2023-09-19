<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Work\Models\Application;
use Domain\Work\Models\Hire;
use Illuminate\Database\Eloquent\Factories\Factory;

class RejectionFactory extends Factory
{
    protected $model = Hire::class;

    public function definition(): array
    {
        return [
            'application_id' => fn() => Application::factory()->createOne()->id,
        ];
    }
}
