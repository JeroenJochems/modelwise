<?php

namespace Database\Factories;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        return [
            'role_id' => fn() => Role::factory()->createOne()->id,
            'model_id' => fn() => Model::factory()->createOne()->id,
        ];
    }
}
