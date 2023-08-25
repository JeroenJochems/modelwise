<?php

namespace Domain\Jobs\Data;

use Domain\Jobs\Enums\ApplicationStatusEnum;
use Domain\Jobs\Models\Application;
use Domain\Profiles\Data\ModelData;
use Spatie\LaravelData\Data;

/** @typescript */
class ApplicationData extends Data
{
    public function __construct(
        public string $id,
        public ApplicationStatusEnum $status,
        public RoleData $role,
        public ModelData $model,
    ) { }

    public static function fromModel(Application $application): static
    {
        return new self(
            $application->id,
            ApplicationStatusEnum::forApplication($application),
            RoleData::from($application->role),
            ModelData::fromModel($application->model),
        );
    }
}
