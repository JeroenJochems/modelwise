<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class ModelPhotosCollection extends Data
{
    public function __construct(
        #[DataCollectionOf(ModelDigitalData::class)]
        public DataCollection $digitals
    ) {
    }
}
