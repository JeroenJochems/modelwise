<?php

namespace Database\Factories\Domain\Jobs\Models;

use Carbon\Carbon;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'job_id' => Job::factory()->createOne()->id,
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->realText,
            'start_date' => Carbon::now()->addWeek(),
        ];
    }
}
