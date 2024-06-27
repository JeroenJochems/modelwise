<?php

namespace Domain\Jobs\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ExtraFieldsData extends Data {

    public function __construct(
        public bool $casting_photos, public  bool $casting_videos)
    {
    }
}
