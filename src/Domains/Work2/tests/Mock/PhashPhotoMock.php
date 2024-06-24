<?php

namespace Domain\Work2\Tests\Mock;


use Domain\Profiles\Models\Photo;
use Support\Actions\PhashPhoto;

class PhashPhotoMock extends PhashPhoto
{
    public static function setUp(): void
    {
        app()->singleton(PhashPhoto::class, fn() => new self);
    }

    public function execute(Photo $photo, $deleteIfNotFound=false)
    {
        $photo->hash = 'hash';
        $photo->save();
    }
}
