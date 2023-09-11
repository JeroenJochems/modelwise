<?php

namespace Domain\Jobs\Data;

use Domain\Jobs\Enums\ApplicationStatusEnum;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Domain\Jobs\Models\Rejection;
use Spatie\LaravelData\Data;

/** @typescript */
class RejectionData extends Data
{
    public function __construct(
        public string $id,
    ) { }

    public static function fromModel(Rejection $rejection): static
    {
        return new self(
            $rejection->id,
        );
    }
}
