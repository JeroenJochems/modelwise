<?php

namespace Domain\Work2\Tests\Mock;


use Support\Actions\MovePhoto;

class MovePhotoMock extends MovePhoto
{
    public static function setUp(): void
    {
        app()->singleton(MovePhoto::class, fn() => new self);
    }

    public function execute($from, $to): bool
    {
        return true;
    }
}
