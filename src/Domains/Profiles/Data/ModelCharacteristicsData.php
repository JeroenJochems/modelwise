<?php

namespace Domain\Profiles\Data;

use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\HairColor;
use Spatie\LaravelData\Data;

/** @typescript */
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
