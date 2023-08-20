<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Portfolio")->with([
            'modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE)
        ]);
    }

    public function store(PhotoRepository $photoRepository)
    {
        $photoRepository->update(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE, request()->get("photos"));

        if (str_contains(request()->server("HTTP_REFERER"), "onboarding")) {
            return redirect()->route("onboarding.digitals");
        }

        return redirect()->route('account.index');
    }
}
