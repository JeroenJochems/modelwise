<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\QueueableAction\QueueableAction;

class StorePortfolioAction
{
    use QueueableAction;

    public function __construct(public PhotoRepository $photoRepository) {}

    public function execute(Model|Authenticatable $user, array $photos)
    {
        $this->photoRepository->update($user, Photo::FOLDER_WORK_EXPERIENCE, $photos);

    }
}
