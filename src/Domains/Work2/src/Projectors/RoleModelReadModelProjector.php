<?php

namespace Domain\Work2\Projectors;


use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Events\ModelWasInvited;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\DB;

class RoleModelReadModelProjector extends TypeBasedProjector
{
    public function onModelHasApplied(ModelHasApplied $event, Message $message)
    {
        DB::table('role_model')->upsert([
            'role_id' => $message->aggregateRootId(),
            'model_id' => $event->model->id,
            'applied_at' => $message->timeOfRecording()->format('Y-m-d H:i:s'),
            'photos' => $event->photos,
            'digitals' => $event->digitals,
            'cover_letter' => $event->coverLetter,
            'brand_conflicted' => $event->brandConflicted,
            'available_dates' => $event->availableDates,
            'casting_questions' => $event->castingQuestions,
            'casting_photos' => $event->castingPhotos,
            'casting_videos' => $event->castingVideos,
        ], ['role_id', 'model_id']);
    }

    public function onModelWasInvited(ModelWasInvited $event, Message $message)
    {
        DB::table('role_model')->upsert([
            'role_id' => $message->aggregateRootId(),
            'model_id' => $event->model->id,
            'invited_at' => $message->timeOfRecording()->format('Y-m-d H:i:s'),
        ], ['role_id', 'model_id']);
    }
}
