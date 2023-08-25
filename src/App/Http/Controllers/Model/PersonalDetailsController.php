<?php

namespace App\Http\Controllers\Model;

use App\ViewModels\CountriesViewModel;
use Domain\Profiles\Data\ModelPersonalDetailsData;
use Inertia\Inertia;

class PersonalDetailsController extends BaseOnboardingController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/PersonalDetails")
            ->with([
                'modelData' => ModelPersonalDetailsData::from(auth()->user()),
                'countriesViewModel' => new CountriesViewModel(),
            ]);
    }

    public function store(ModelPersonalDetailsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());
        $model->save();

        return $this->nextOrReturn();
    }
}
