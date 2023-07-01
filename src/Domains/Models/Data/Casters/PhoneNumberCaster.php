<?php

namespace Domain\Models\Data\Casters;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class PhoneNumberCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return "+" . preg_replace("/[^0-9]/", "", $value);
    }
}
