<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ModelPhotosCollection extends Data
{
    public function __construct(
        #[DataCollectionOf(ModelPhotoData::class)]
        public DataCollection $photos
    ) {
    }
}
