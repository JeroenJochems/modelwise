<?php

namespace Domain\Work2\Events;

use Domain\Work2\Data\ApplyData;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ModelHasApplied implements SerializablePayload
{
    public function __construct(
        public int $modelId,
        public ApplyData $applyData,
    ) {}

    public static function fromPayload(array $payload): static
    {
        return new static(
            $payload['model_id'],
            ApplyData::from($payload['apply_data']),
        );
    }

    public function toPayload(): array
    {
        return [
            'model_id' => $this->modelId,
            'apply_data' => $this->applyData->toJson(),
        ];
    }
}
