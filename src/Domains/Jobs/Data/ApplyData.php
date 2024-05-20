<?php

namespace Domain\Jobs\Data;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;

class ApplyData extends Data
{
    #[WithoutValidation]
    public Model|Authenticatable $model;

    #[WithoutValidation]
    public Role $role;

    public function __construct(
        public ?string $cover_letter,
        public array $digitals,
        public array $photos,
        public ?array $available_dates,

        public ?int $height,
        public ?int $chest,
        public ?int $waist,
        public ?int $hips,
        public ?int $shoe_size,
        public ?string $clothing_size_top,
        public ?string $brand_conflicted,
        public ?string $casting_questions,
    ) {
        $this->model = Auth::user();

        /** @phpstan-ignore-next-line  */
        $this->role = request()->route("role");
    }


    public static function messages(...$args): array
    {
        return [
            'available_dates.min' => 'Without your availability, we cannot process your application.',
            'digitals.min' => 'Upload at least three digitals.',
            'digitals.required' => 'Upload at least three digitals.',
            'photos.min' => 'Upload at least three photos.',
            'photos.required' => 'Upload at least three photos.'
        ];
    }
}
