<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Data\ModelPersonalDetailsData;
use Inertia\Inertia;

class PersonalDetailsController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/PersonalDetails")
            ->with(['modelData' => ModelPersonalDetailsData::from(auth()->user())]);
    }

    public function store(ModelPersonalDetailsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());
        $model->save();

        return redirect()->route("account.index");
    }


}
