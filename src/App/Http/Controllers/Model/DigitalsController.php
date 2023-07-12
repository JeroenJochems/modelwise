<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Domain\Models\Models\Photo;
use Domain\Models\Repositories\PhotoRepository;
use Inertia\Inertia;

class DigitalsController extends Controller
{
    public function index(PhotoRepository $photoRepository)
    {
        return Inertia::render("Model/Onboarding/Digitals")->with([
            'modelDigitals' => $photoRepository->getPhotos(auth()->user(), Photo::FOLDER_DIGITALS)
        ]);
    }

    public function store(PhotoRepository $photoRepository)
    {
        $photoRepository->update(auth()->user(), Photo::FOLDER_DIGITALS, request()->get("photos"));

        return redirect()->route('account.index');
    }

}
