<?php

namespace App\Http\Controllers\Model;

use App\ViewModels\SkillsViewModel;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillsController extends BaseOnboardingController
{
    public function index(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Skills")
            ->with([
                'vm' => new SkillsViewModel(auth()->user()),
                'modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_ACTIVITIES)
            ]);
    }

    public function store(PhotoRepository $photoRepository, Request $request)
    {
        /** @var Model $model */
        $model = auth()->user();

        $photoRepository->update($model, Photo::FOLDER_ACTIVITIES, $request->get("photos"));

        ray($request->get('skills'));


        $model->syncTagsWithType($request->get('skills'), Model::TAG_TYPE_SKILLS);
        $model->save();

        return $this->nextOrReturn();
    }
}
