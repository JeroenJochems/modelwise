<?php

namespace Domain\Jobs\Data;

use Domain\Work\Models\Hire;
use Spatie\LaravelData\Data;

/** @typescript */
class HireData extends Data
{
    public function __construct(
        public string $id,
    ) { }

    public static function fromModel(Hire $hire): static
    {
        return new self(
            $hire->id,
        );
    }
}
