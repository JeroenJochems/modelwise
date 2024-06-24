<?php

namespace Domain\Work2\Reactors;

use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Projectors\TypeBasedProjector;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\DB;

class UpdateModelCharacteristics extends TypeBasedProjector
{
    public function handleModelHasApplied(ModelHasApplied $event, Message $message)
    {
        DB::table('models')->where('id', $event->modelId)->update([
            'height' => $event->applyData->height,
            'chest' => $event->applyData->chest,
            'waist' => $event->applyData->waist,
            'hips' => $event->applyData->hips,
            'shoe_size' => $event->applyData->shoe_size,
            'clothing_size_top' => $event->applyData->clothing_size_top,
        ]);
    }

}

