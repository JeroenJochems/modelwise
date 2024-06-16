<?php

namespace Domain\Work2\Events;

use Domain\Profiles\Models\Model;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Illuminate\Database\Eloquent\Collection;

class UpdatedFavorites implements SerializablePayload
{

    public function __construct(public Collection $models)
    {
    }

    public function toPayload(): array
    {
        return [
            'models' => $this->models->pluck('id')->toArray(),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            Model::find($payload['models'])
        );
    }
}
