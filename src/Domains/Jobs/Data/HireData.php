<?php

namespace Domain\Jobs\Data;

use Domain\Jobs\Enums\ApplicationStatusEnum;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Spatie\LaravelData\Data;

/** @typescript */
class HireData extends Data
{
    public function __construct(
        public string $id,
        public ApplicationData $application,
    ) { }

    public static function fromModel(Hire $hire): static
    {
        return new self(
            $hire->id,
            ApplicationData::from($hire->application),
        );
    }
}
