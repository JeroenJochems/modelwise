<?php

namespace Domain\Work2\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class UpdatedFavorites implements SerializablePayload
{
    /**
     * @param array<int> $modelIds
     */
    public function __construct(public array $modelIds)
    {
    }

    public function toPayload(): array
    {
        return [
            'models' => $this->modelIds,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            modelIds: $payload['models'],
        );
    }
}
