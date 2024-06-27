<?php

namespace Domain\Jobs\Data;

use Domain\Profiles\Data\PhotoData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class JobData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $location,
        public ?BrandData $brand,
        public ?ClientData $client,

        /** @var null|PhotoData[] */
        public ?array $look_and_feel_photos,
    ) { }
}
