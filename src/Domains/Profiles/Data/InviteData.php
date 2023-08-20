<?php

namespace Domain\Profiles\Data;

use DateTime;
use Domain\Jobs\Data\JobData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

/** @typescript */
class InviteData extends Data
{
    public function __construct(
        public RoleData $role,
        public ModelData $model,
    ) { }
}
