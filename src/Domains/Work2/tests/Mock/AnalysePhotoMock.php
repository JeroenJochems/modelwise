<?php

namespace Tests\Work2\Mock;

use Domain\Profiles\Actions\AnalysePhoto;
use Domain\Profiles\Models\Photo;

class AnalysePhotoMock extends AnalysePhoto
{
    public static function setUp(): void
    {
        app()->singleton(self::class, fn() => new self);
    }

    public function execute(Photo $photo)
    {

    }
}
