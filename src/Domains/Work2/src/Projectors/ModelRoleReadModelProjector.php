<?php

namespace Domain\Work2\Projectors;


use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Events\ModelWasAddedToRole;
use Domain\Work2\Events\ModelWasInvited;
use Domain\Work2\Events\ModelWasRejected;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\DB;

class ModelRoleReadModelProjector extends TypeBasedProjector
{
    public function onModelWasAddedToRole(ModelWasAddedToRole $event, Message $message)
    {
        $this->upsert([
            'model_id' => $event->modelId,
            'role_id' => $message->aggregateRootId(),
        ]);
    }

    public function onModelHasApplied(ModelHasApplied $event, Message $message)
    {
        $this->upsert([
            'model_id' => $event->modelId,
            'role_id' => $message->aggregateRootId(),
            'applied_at' => $message->timeOfRecording()->format('Y-m-d H:i:s'),
            'photos' => json_encode($event->applyData->photos),
            'digitals' => json_encode($event->applyData->digitals),
            'cover_letter' => $event->applyData->cover_letter,
            'brand_conflicted' => $event->applyData->brand_conflicted,
            'available_dates' => json_encode($event->applyData->available_dates),
            'casting_questions' => $event->applyData->casting_questions,
        ]);
    }

    public function onModelWasInvited(ModelWasInvited $event, Message $message)
    {
        $this->upsert([
            'model_id' => $event->modelId,
            'role_id' => $message->aggregateRootId(),
            'invited_at' => $message->timeOfRecording()->format('Y-m-d H:i:s'),
        ]);
    }

    public function onModelWasRejected(ModelWasRejected $event, Message $message)
    {
        $this->upsert([
            'model_id' => $event->modelId,
            'role_id' => $message->aggregateRootId(),
            'rejected_at' => $message->timeOfRecording()->format('Y-m-d H:i:s'),
        ]);
    }

    protected function upsert(array $data)
    {
        $completeData = [...$data, 'created_at' => now(), 'updated_at' => now()];

        DB::table('listings')->upsert(
            $completeData,
            ['role_id', 'model_id'],
            array_filter(array_keys($completeData), fn($key) => $key !== 'created_at')
        );
    }
}
