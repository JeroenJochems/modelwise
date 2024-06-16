<?php

namespace Domain\Work2\Events;

use Domain\Profiles\Models\Model;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ModelHasApplied implements SerializablePayload
{

    public function __construct(
        public Model $model,
        public array $photos,
        public array $digitals,
        public string $coverLetter,
        public bool $brandConflicted,
        public array $availableDates,
        public ?string $castingQuestions = null,
        public ?array $castingPhotos = null,
        public ?array $castingVideos = null,
    ) {}

    public static function fromPayload(array $payload): static
    {
        return new static(
            Model::find($payload['model_id']),
            $payload['photos'],
            $payload['digitals'],
            $payload['cover_letter'],
            $payload['brand_conflicted'],
            $payload['available_dates'],
            $payload['casting_questions'],
            $payload['casting_photos'],
            $payload['casting_videos'],
        );
    }

    public function toPayload(): array
    {
        return [
            'model_id' => $this->model->id,
            'photos' => $this->photos,
            'digitals' => $this->digitals,
            'cover_letter' => $this->coverLetter,
            'brand_conflicted' => $this->brandConflicted,
            'available_dates' => $this->availableDates,
            'casting_questions' => $this->castingQuestions,
            'casting_photos' => $this->castingPhotos,
            'casting_videos' => $this->castingVideos,
        ];
    }
}
