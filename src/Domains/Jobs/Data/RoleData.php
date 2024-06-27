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
class RoleData extends Data
{
    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @param Carbon|null $start_date
     * @param Carbon|null $end_date
     * @param int $fee
     * @param int $buyout
     * @param string|null $buyout_note
     * @param string|null $travel_reimbursement_note
     * @param null|PhotoData[] $photos
     * @param null|PhotoData[] $public_photos
     * @param JobData|null $job
     * @param string|null $casting_video_instructions
     * @param string|null $casting_photo_instructions
     * @param string|null $casting_questions
     * @param FieldsData|null $fields
     * @param ExtraFieldsData|null $extra_fields
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public Carbon $start_date,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?Carbon $end_date,
        public int $fee,
        public int $buyout,
        public ?string $buyout_note,
        public ?string $travel_reimbursement_note,

        public ?array $photos,
        public ?array $public_photos,
        public JobData $job,

        public ?string $casting_video_instructions,
        public ?string $casting_photo_instructions,
        public ?string $casting_questions,

        public FieldsData $fields,
        public ExtraFieldsData $extra_fields,

    ) {
    }
}
