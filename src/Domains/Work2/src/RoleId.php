<?php

namespace Domain\Work2;

use EventSauce\EventSourcing\AggregateRootId;

class RoleId implements AggregateRootId
{
    public function __construct(
        private string $id
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
    
    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }
}
