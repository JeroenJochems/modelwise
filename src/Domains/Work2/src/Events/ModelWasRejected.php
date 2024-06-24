<?php

namespace Domain\Work2\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ModelWasRejected implements SerializablePayload
{

    public function __construct(
        public int $modelId,
        public string $messageSubject,
        public string $messageBody,
    )
    {
    }

    public function toPayload(): array
    {
        return [
            'model_id' => $this->modelId,
            'message_subject' => $this->messageSubject,
            'message_body' => $this->messageBody,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            modelId: $payload['model_id'],
            messageSubject: $payload['message_subject'],
            messageBody: $payload['message_body'],
        );
    }

}
