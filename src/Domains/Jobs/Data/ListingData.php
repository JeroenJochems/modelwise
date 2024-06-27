<?php

namespace Domain\Jobs\Data;

use Carbon\Carbon;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Data\PhotoData;
use Domain\Profiles\Data\VideoData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ListingData extends Data
{
    public string $status;
    public function __construct(
        public string $id,
        public string $model_id,
        public ModelData $model,
        public RoleData $role,

        public ?Carbon $invited_at,
        public ?Carbon $applied_at,
        public ?Carbon $extended_application_at,
        public ?Carbon $shortlisted_at,
        public ?Carbon $hired_at,
        public ?Carbon $favorited_at,
        public ?Carbon $rejected_at,

        public ?string $cover_letter,
        public ?string $brand_conflicted,
        public ?string $casting_questions,

        public ?array $available_dates,

        /** @var PhotoData[] $photos */
        public array $photos,

        /** @var PhotoData[] $casting_photos */
        public array $casting_photos,

        /** @var VideoData[] $casting_videos */
        public array $casting_videos,
    )
    {
        if (!!$hired_at) $this->status = 'Hired';
        elseif (!!$rejected_at) $this->status = 'Rejected';
        elseif (!!$shortlisted_at) $this->status = 'Shortlisted';
        elseif (!!$applied_at) $this->status = 'Applied';
        elseif (!!$invited_at) $this->status = 'Invited';
        else $this->status = 'New';
    }
}
