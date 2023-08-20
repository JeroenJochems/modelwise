<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class ModelDigitalsCollection extends Data
{
    public function __construct(
        #[DataCollectionOf(ModelPhotoData::class)]
        public DataCollection $digitals
    ) {
    }
}
