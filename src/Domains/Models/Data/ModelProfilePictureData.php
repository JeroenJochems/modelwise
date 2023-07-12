<?php

namespace Domain\Models\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class ModelProfilePictureData extends Data
{
    public function __construct(
        #[WithTransformer(CdnPathTransformer::class)]
        public ?string $profile_picture
    ) {
    }
}
