<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Jobs\Models\Client;
use Domain\Jobs\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'client_id' => fn() => Client::factory()->createOne()->id,
            'title' => $this->faker->jobTitle,
            'location' => $this->faker->city,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
