<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use DateTime;
use Domain\Jobs\Data\ListingData;
use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\HairColor;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/** @typescript */
class ModelData extends Data
{
    public function __construct(

        public ?string $id,

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

        /** @var null|ModelPhotoData[] */
        public ?array $portfolio,

        /** @var null|ModelPhotoData[] */
        public ?array $digitals,

        /** @var null|ModelPhotoData[] */
        public ?array $tattoo_photos,

        /** @var null|ListingData[] */
        public ?array $listings,

        public ?HairColor $hair_color,
        public EyeColor|string|null $eye_color,
        public string|null $eye_color_other,
        public ?int $height,
        public ?int $chest,
        public ?int $waist,
        public ?int $hips,
        public ?int $shoe_size,
        public ?string $clothing_size_top,
        public ?string $cup_size,

        public ?string $instagram,
        public ?string $tiktok,
        public ?string $website,
        public ?string $showreel_link,
    ) {}
}
