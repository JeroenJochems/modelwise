<?php

namespace Domain\Jobs\Data;

use Domain\Jobs\Enums\ApplicationStatusEnum;
use Domain\Jobs\Models\Application;
use Domain\Profiles\Data\ModelData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

/** @typescript */
class ApplicationData extends Data
{
    public function __construct(
        public string $id,
        public ApplicationStatusEnum $status,
        public ?HireData $hire,
        public ?RejectionData $rejection,
    ) { }

    public static function fromModel(Application $application): static
    {
        return new self(
            $application->id,
            ApplicationStatusEnum::forApplication($application),
            $application->hire ? HireData::fromModel($application->hire) : null ,
            $application->rejection ? RejectionData::fromModel($application->rejection) : null ,
        );
    }
}
