<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ModelDigitalsCollection extends Data
{
    public function __construct(
        #[DataCollectionOf(ModelDigitalData::class)]
        public DataCollection $digitals
    ) {
    }
}
