<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Domain\Profiles\Data\ModelCharacteristicsData;
use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\HairColor;
use Domain\Profiles\Repositories\PhotoRepository;
use Inertia\Inertia;

class CharacteristicsController extends BaseOnboardingController
{
    public function index(PhotoRepository $photoRepository)
    {
        return Inertia::render("Model/Onboarding/Characteristics")
            ->with([
                'modelData' => ModelCharacteristicsData::from(auth()->user())->toArray(),
                'eyeColors' => EyeColor::cases(),
                'hairColors' => HairColor::cases(),
                'tattooPhotos' => $photoRepository->getPhotos(auth()->user(), "Tattoos")
            ]);
    }

    public function store(ModelCharacteristicsData $data, PhotoRepository $photoRepository)
    {
        if (request()->has("tattoo_photos")) {
            $photoRepository->update(auth()->user(), "Tattoos", request()->get("tattoo_photos"));
        }

        $model = auth()->user();
        $model->update($data->toArray());
        $model->save();

        return $this->nextOrReturn();
    }
}
