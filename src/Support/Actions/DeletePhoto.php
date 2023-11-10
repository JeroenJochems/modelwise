<?php

namespace Support\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class DeletePhoto
{
    use QueueableAction;

    public function execute($path)
    {
        Storage::delete($path);
    }

}
