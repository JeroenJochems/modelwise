<?php

namespace Domain\Work2\Events;

use Domain\Profiles\Models\Model;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ModelWasShortlisted implements SerializablePayload
{

    public function __construct(
        public Model $model
    )
    {
    }

    public function toPayload(): array
    {
        return [
            'model_id' => $this->model->id,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            Model::find($payload['model_id'])
        );
    }
}
