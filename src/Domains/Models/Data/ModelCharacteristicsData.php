<?php

namespace Domain\Models\Data;

use Domain\Models\Enums\EyeColor;
use Domain\Models\Enums\HairColor;
use Spatie\LaravelData\Data;

class ModelCharacteristicsData extends Data
{
    public function __construct(
        public ?string $gender,
        public ?HairColor $hair_color,
        public ?string $hair_color_other,
        public ?EyeColor $eye_color,
        public ?string $eye_color_other,
        public ?string $height,
        public ?string $chest,
        public ?string $waist,
        public ?string $hips,
        public ?string $shoe_size,
        public ?string $cup_size,
        public ?bool $tattoos,
        public ?bool $piercings
    ) {
    }
}
