<?php

namespace Domain\Profiles\Data;

use Carbon\Carbon;
use DateTime;
use Domain\Profiles\Data\Casters\PhoneNumberCaster;
use Spatie\LaravelData\Attributes\Validation\AfterOrEqual;
use Spatie\LaravelData\Attributes\Validation\BeforeOrEqual;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;


/** @typescript */
class ModelPersonalDetailsData extends Data
{
    public function __construct(

        #[Rule(['required', 'min:2'])]
        public ?string $first_name,

        #[Rule(['required', 'min:2'])]
        public ?string $last_name,

        #[Rule(['required', 'min:10'])]
        public ?string $phone_number,

        #[Rule(['required', 'min:2'])]
        public ?string $city,

        #[Rule(['required'])]
        public ?string $country,

        #[Rule(['required'])]
        public ?string $gender,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?DateTime $date_of_birth,
    ) {
    }
}
