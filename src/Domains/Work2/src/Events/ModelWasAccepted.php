<?php

namespace Domain\Work2\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ModelWasAccepted implements SerializablePayload
{

    public function __construct(
        public int $modelId
    )
    {
    }

    public function toPayload(): array
    {
        return [
            'model_id' => $this->modelId,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            modelId: $payload['model_id'],
        );
    }

}
