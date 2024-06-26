<?php

namespace Domain\Jobs\Data;

use Carbon\Carbon;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Data\PhotoData;
use Domain\Profiles\Data\VideoData;
use Spatie\LaravelData\Data;

/** @typescript */
class ListingData extends Data
{
    public string $status;

    /**
     * @param string $id
     * @param string $model_id
     * @param Carbon|null $invited_at
     * @param Carbon|null $applied_at
     * @param Carbon|null $shortlisted_at
     * @param Carbon|null $extended_application_at
     * @param Carbon|null $hired_at
     * @param Carbon|null $rejected_at
     * @param string|null $cover_letter
     * @param string|null $brand_conflicted
     * @param string|null $casting_questions
     * @param array|null $available_dates
     * @param array|null $photos
     * @param PhotoData[]|null $casting_photos
     * @param VideoData[]|null $casting_videos
     * @param ModelData $model
     * @param RoleData $role
     */
    public function __construct(
        public string $id,
        public string $model_id,
        public ?ModelData $model,
        public ?RoleData $role,

        public ?Carbon $invited_at,
        public ?Carbon $applied_at,
        public ?Carbon $extended_application_at,
        public ?Carbon $shortlisted_at,
        public ?Carbon $hired_at,
        public ?Carbon $rejected_at,

        public ?string $cover_letter,
        public ?string $brand_conflicted,
        public ?string $casting_questions,

        public ?array $available_dates,
        public ?array $photos,
        public ?array $casting_photos,
        public ?array $casting_videos,

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
