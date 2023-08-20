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
        public int $buyout,
        public ?string $buyout_note,
        public ?string $travel_reimbursement_note,

        #[DataCollectionOf(PhotoData::class)]
        /** @var PhotoData[] */
        public Lazy|DataCollection $photos,

        #[DataCollectionOf(PhotoData::class)]
        /** @var PhotoData[] */
        public Lazy|DataCollection $public_photos,

        public JobData $job,
    ) { }
}
