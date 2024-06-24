<?php

namespace Domain\Work2\Data;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Repositories\PhotoRepository;
use Spatie\LaravelData\Data;

class ApplyData extends Data
{
    public function __construct(
        public ?string $cover_letter,

        /** @var array{id: string, path: string, isNew: bool, mime: string} $photos */
        public ?array $digitals,

        /** @var array{id: string, path: string, isNew: bool, mime: string} $photos */
        public ?array $photos,
        public ?array $available_dates,
        public ?string $brand_conflicted,
        public ?string $casting_questions,

        public ?int $height = null,
        public ?int $chest = null,
        public ?int $waist = null,
        public ?int $hips = null,
        public ?int $shoe_size = null,
        public ?string $clothing_size_top = null,
    ) { }

    /**
     * @param array{
     *      cover_letter: string,
     *      digitals: array<array{id: string, path: string, isNew: bool, mime: string, deleted: bool}>,
     *      photos: array<array{id: string, path: string, isNew: bool, mime: string, deleted: bool}>,
     *      available_dates: array<string>,
     *      brand_conflicted: string,
     *      casting_questions: string,
     *      height: int,
     *      chest: int,
     *      waist: int,
     *      hips: int,
     *      shoe_size: int,
     *      clothing_size_top: string
     *  } $request
     * @return self
     */
    public static function fromRequest(Model $model, array $request): self
    {
        return new self(
            cover_letter: $request['cover_letter'] ?? null,
            digitals: app(PhotoRepository::class)->store($model, $request['digitals']),
            photos: app(PhotoRepository::class)->store($model, $request['photos']),
            available_dates: $request['available_dates'] ?? [],
            brand_conflicted: $request['brand_conflicted'] ?? null,
            casting_questions: $request['casting_questions'] ?? null,
            height: $request['height'] ?? null,
            chest: $request['chest'] ?? null,
            waist: $request['waist'] ?? null,
            hips: $request['hips'] ?? null,
            shoe_size: $request['shoe_size'] ?? null,
            clothing_size_top: $request['clothing_size_top'] ?? null,
        );
    }
}
