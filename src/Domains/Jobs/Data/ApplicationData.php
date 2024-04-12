<?php

namespace Domain\Jobs\Data;

use Carbon\Carbon;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Data\PhotoData;
use Domain\Profiles\Data\VideoData;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class ApplicationData extends Data
{
    #[Computed]
    public bool $is_shortlisted;

    #[Computed]
    public bool $is_rejected;

    public function __construct(
        public string $id,
        public string $model_id,
        public ?string $cover_letter,
        public ?string $casting_questions,
        public ?string $brand_conflicted,

        ?Carbon $shortlisted_at,
        ?Carbon $rejected_at,

        #[DataCollectionOf(PhotoData::class)]
        /** @var PhotoData[] */
        public DataCollection $photos,

        public ModelData $model,

        #[DataCollectionOf(PhotoData::class)]
        /** @var PhotoData[] */
        public DataCollection $casting_photos,

        #[DataCollectionOf(VideoData::class)]
        /** @var VideoData[] */
        public DataCollection $casting_videos,

        public ?HireData $hire,
    )
    {
        $this->is_shortlisted = $shortlisted_at !== null;
        $this->is_rejected = $rejected_at !== null;
    }
}
