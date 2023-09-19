<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Inertia\Inertia;

class PortfolioController extends BaseOnboardingController
{
    public function index(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Portfolio")
            ->with([
                'modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE)
            ]);
    }

    public function store(PhotoRepository $photoRepository)
    {
        $photoRepository->update(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE, request()->get("photos"));

        return $this->nextOrReturn();
    }
}
