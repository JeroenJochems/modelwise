<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use DateTime;
use Domain\Jobs\Data\ApplicationData;
use Domain\Profiles\Models\Model;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

/** @typescript */
class ModelData extends Data
{
    public function __construct(
        #[WithTransformer(CdnPathTransformer::class)]
        public ?string $profile_picture,

        public ?string $first_name,
        public ?string $last_name,
        public ?string $phone_number,
        public ?string $city,
        public ?string $country,
        public ?string $gender,

        #[WithCast(DateTimeInterfaceCast::class)]
        public ?DateTime $date_of_birth,

        /** @var ModelPhotoData[] */
        #[DataCollectionOf(ModelPhotoData::class)]
        public Lazy|DataCollection $portfolio,

        /** @var ModelPhotoData[] */
        #[DataCollectionOf(ModelPhotoData::class)]
        public Lazy|DataCollection $digitals,

        /** @var ModelPhotoData[] */
        #[DataCollectionOf(ModelPhotoData::class)]
        public Lazy|DataCollection $tattoo_photos,

        /** @var ApplicationData[] */
        #[DataCollectionOf(ApplicationData::class)]
        public Lazy|DataCollection $applications,

        public ?int $height,
        public ?int $chest,
        public ?int $waist,
        public ?int $hips,
        public ?int $shoe_size,
        public ?string $clothing_size_top,
    ) {}

    public static function fromModel(Model $model): self
    {
        return new self(
            $model->profile_picture,
            $model->first_name,
            $model->last_name,
            $model->phone_number,
            $model->city,
            $model->country,
            $model->gender,
            $model->date_of_birth,
            Lazy::whenLoaded('portfolio', $model, fn() => ModelPhotoData::collection($model->portfolio)),
            Lazy::whenLoaded('digitals', $model, fn() => ModelPhotoData::collection($model->digitals)),
            Lazy::whenLoaded('tattoo_photos', $model, fn() => ModelPhotoData::collection($model->tattoo_photos)),
            Lazy::whenLoaded('applications', $model, fn() => ApplicationData::collection($model->applications)),
            $model->height,
            $model->chest,
            $model->waist,
            $model->hips,
            $model->shoe_size,
            $model->clothing_size_top,
        );
    }
}
