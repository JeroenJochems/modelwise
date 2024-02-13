<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Inertia\Inertia;

class ActivitiesController extends BaseOnboardingController
{
    public function index(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Activities")
            ->with([
                'modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_ACTIVITIES)
            ]);
    }

    public function store(PhotoRepository $photoRepository)
    {
        $photoRepository->update(auth()->user(), Photo::FOLDER_ACTIVITIES, request()->get("photos"));

        return $this->nextOrReturn();
    }
}
