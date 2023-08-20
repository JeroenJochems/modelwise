<?php

namespace Database\Factories\Domain\Jobs\Models;

use Domain\Jobs\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
        ];
    }
}
