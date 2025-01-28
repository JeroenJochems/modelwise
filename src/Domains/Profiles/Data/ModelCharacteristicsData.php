<?php

namespace Domain\Profiles\Data;

use App\ViewModels\Tag;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\HairColor;
use Domain\Profiles\Models\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\Tags\Tag as TagModel;

/** @typescript */
class ModelCharacteristicsData extends Data
{
    public function __construct(
        public ?string $gender,
        public ?HairColor $hair_color,
        public ?Ethnicity $ethnicity,
        public ?string $ethnicity_other,
        public ?string $hair_color_other,
        public ?EyeColor $eye_color,
        public ?string $eye_color_other,

        #[Rule(['numeric', 'max:251'])]
        public ?string $height,
        #[Rule(['numeric', 'max:200'])]
        public ?string $chest,
        #[Rule(['numeric', 'max:200'])]
        public ?string $waist,
        #[Rule(['numeric', 'max:200'])]
        public ?string $hips,
        #[Rule(['numeric', 'max:55'])]
        public ?string $shoe_size,
        public ?string $clothing_size_top,
        public ?string $cup_size,
        public ?bool $tattoos,
        public ?bool $piercings
    ) { }
}
