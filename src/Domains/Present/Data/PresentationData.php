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
        public bool $should_show_casting_media,
        public bool $should_show_digitals,
        public bool $should_show_socials,
        public bool $should_show_cover_letter,
        public bool $should_show_conflicts
    )
    { }
}
