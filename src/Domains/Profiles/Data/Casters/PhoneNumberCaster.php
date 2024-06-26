<?php

namespace Domain\Profiles\Data\Casters;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class PhoneNumberCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        return "+" . preg_replace("/[^0-9]/", "", $value);
    }
}
