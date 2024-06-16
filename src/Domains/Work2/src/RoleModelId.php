<?php

namespace Domain\Work2;

use EventSauce\EventSourcing\AggregateRootId;

class RoleModelId implements AggregateRootId
{
    public function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }
}
