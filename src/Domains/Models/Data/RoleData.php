<?php

namespace Domain\Models\Data;

use DateTime;
use Domain\Jobs\Data\JobData;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

/** @typescript */
class RoleData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public DateTime $start_date,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?DateTime $end_date,

        public int $fee,
        public ?string $fee_note,
        public int $buyout,
        public ?string $buyout_note,
        public ?string $travel_reimbursement_note,

        public JobData $job,
    ) { }
}
