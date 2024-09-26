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
            $tempUrl = $photo->cdn_path;

            $photo->hash = (new PHash())->getHash($tempUrl);
            $photo->save();
        } catch (\Exception $e) {
            if ($deleteIfNotFound && str_contains($e->getMessage(), "404 Not Found")) {
                $photo->delete();
            }
        }
    }
}
