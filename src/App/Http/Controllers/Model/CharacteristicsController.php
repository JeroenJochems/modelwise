<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\ViewModels\ModelTagsViewModel;
use Domain\Profiles\Data\ModelCharacteristicsData;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\HairColor;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Inertia\Inertia;

class CharacteristicsController extends BaseOnboardingController
{
    public function index(PhotoRepository $photoRepository)
    {
        $user = auth()->user();

        return Inertia::render("Model/Onboarding/Characteristics")
            ->with([
                'modelTagsViewModel' => new ModelTagsViewModel($user),
                'modelData' => ModelCharacteristicsData::from($user)->toArray(),
                'eyeColors' => EyeColor::cases(),
                'ethnicities' => Ethnicity::toArray(),
                'hairColors' => HairColor::cases(),
                'tattooPhotos' => $photoRepository->getPhotos($user, Photo::FOLDER_TATTOOS),
                'piercingPhotos' => $photoRepository->getPhotos($user, Photo::FOLDER_PIERCINGS)
            ]);
    }

    public function store(ModelCharacteristicsData $data, PhotoRepository $photoRepository)
    {
        $model = auth()->user();
        $model->update($data->toArray());
        $model->syncTagsWithType(request()->input('looks'), Model::TAG_TYPE_LOOKS);

        $model->save();

        if (request()->has("tattoo_photos")) {
            $photoRepository->update($model, Photo::FOLDER_TATTOOS, request()->get("tattoo_photos"));
        };

        if (request()->has("piercing_photos")) {
            $photoRepository->update($model, Photo::FOLDER_PIERCINGS, request()->get("piercing_photos"));
        }

        return $this->nextOrReturn();
    }
}
