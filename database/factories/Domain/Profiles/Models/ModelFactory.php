<?php

namespace Database\Factories\Domain\Profiles\Models;

use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ModelFactory extends Factory
{
    protected $model = Model::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'password' => Hash::make('secret'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => 'Male',
        ];
    }
}
