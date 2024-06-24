<?php

namespace Domain\Work2\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class RoleWasCreated implements SerializablePayload
{
    public function __construct(
        public int $roleId)
    { }

    public function toPayload(): array
    {
        return [
            'role_id' => $this->roleId,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            roleId: $payload['role_id'],
        );
    }
}
