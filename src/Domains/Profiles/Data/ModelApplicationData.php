<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use Domain\Jobs\Enums\ApplicationStatusEnum;
use Domain\Jobs\Models\Application;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class ModelApplicationData extends Data
{
    public function __construct(
        public string $id,
        public ApplicationStatusEnum $status,
        public RoleData $role,
    ) { }

    public static function fromModel(Application $application): static
    {
        return new self(
            $application->id,
            ApplicationStatusEnum::forApplication($application),
            RoleData::from($application->role),
        );
    }
}
