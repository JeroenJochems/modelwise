<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;

class StorePortfolioInteractor
{
    public function __construct(public PhotoRepository $photoRepository) {}

    public function execute($user, $photos)
    {
        $this->photoRepository->update($user, Photo::FOLDER_WORK_EXPERIENCE, $photos);
    }
}
