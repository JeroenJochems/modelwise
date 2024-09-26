<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Actions\StorePortfolioAction;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PortfolioController extends BaseOnboardingController
{
    public function index(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Portfolio")
            ->with(['modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE)]);
    }

    public function store(Request $request, PhotoRepository $photoRepository)
    {
        app(StorePortfolioAction::class)->execute(
            auth()->user(),
            $request->get("photos")
        );

        return $this->nextOrReturn();
    }
}
