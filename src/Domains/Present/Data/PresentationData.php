<?php

namespace Domain\Present\Data;

use Domain\Jobs\Data\RoleData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PresentationData extends Data
{
    public function __construct(
        public string $id,
        public RoleData $role,
        public bool $should_show_name,
        public bool $should_show_casting_media,
        public bool $should_show_digitals,
        public bool $should_show_socials,
        public bool $should_show_cover_letter,
        public bool $should_show_conflicts,
        public bool $should_show_age,
        public bool $should_show_city,
        public bool $should_show_height,
        public bool $should_show_waist,
        public bool $should_show_hips,
        public bool $should_show_hair_color,
        public bool $should_show_eye_color,
        public bool $should_show_clothing_size,
        public bool $should_show_shoe_size,
        public bool $should_show_cup_size,
    )
    { }
}
