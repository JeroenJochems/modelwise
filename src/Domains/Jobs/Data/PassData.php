<?php

namespace Domain\Jobs\Data;

use Carbon\Carbon;
use DateTime;
use Domain\Profiles\Data\PhotoData;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

/** @typescript */
class PassData extends Data
{
    public function __construct(
        public int $id,
        public string $model_id,
        public string $role_id,
    ) { }
}
