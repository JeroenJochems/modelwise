<?php

namespace Support\Actions;

use Domain\Profiles\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class DeletePhoto
{
    use QueueableAction;

    public function execute(Photo $photoObj)
    {
        $photoObj->delete();
    }

}
