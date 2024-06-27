<?php

namespace Support\Actions;

use Domain\Profiles\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Support\PHash;

class PhashPhoto
{
    use QueueableAction;

    public function execute(Photo $photo, $deleteIfNotFound = false)
    {
        try {
            $photo->hash = (new PHash())->getHash(
                Storage::temporaryUrl($photo->path, now()->addMinutes(5)),
            );
            $photo->save();
        } catch (\Exception $e) {
            if ($deleteIfNotFound && str_contains($e->getMessage(), "404 Not Found")) {
                $photo->delete();
            }
        }
    }
}
