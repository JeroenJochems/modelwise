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
            'job_id' => fn() => Job::factory()->createOne()->id,
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->realText,
            'start_date' => Carbon::now()->addWeek(),
            'fee' => 150,
            'buyout' => 200,
            'fields' => [
                'digitals' => true,
                'height' => true,
                'chest' => true,
                'waist' => true,
                'hips' => true,
                'shoe_size' => true,
                'clothing_size_top' => true,
                'head' => true,
                ],
            'extra_fields' => [
                'casting_photos' => true,
                'casting_videos' => true
            ],
        ];
    }
}
