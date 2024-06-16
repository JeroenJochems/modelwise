<?php

namespace Domain\Work2\Events;

use Domain\Jobs\Models\Role;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class RoleWasCreated implements SerializablePayload
{
    public function __construct(
        public Role $role)
    { }

    public function toPayload(): array
    {
        return [
            'role_id' => $this->role->id,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            Role::find($payload['role_id'])
        );
    }
}
