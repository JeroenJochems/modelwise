<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Jobs\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
        ];
    }
}
