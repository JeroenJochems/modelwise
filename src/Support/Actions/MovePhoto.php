<?php

namespace Support\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class MovePhoto
{
    use QueueableAction;

    public function execute($from, $to)
    {
        Storage::copy($from, $to);
    }

}
