<?php

namespace App\Http\Controllers\Model;

use Domain\Models\Data\ModelProfilePictureData;
use Domain\Models\Models\Model;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfilePictureController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/ProfilePicture")
            ->with(['modelData' => ModelProfilePictureData::from(auth()->user())]);
    }

    public function store(ModelProfilePictureData $data)
    {
        if (!$data->profile_picture) {
            return redirect()->route("account.index");
        }

        /** @var Model $model */
        $model = auth()->user();
        $model->profile_picture = str_replace("tmp/", "profile_pictures/", $data->profile_picture);

        Storage::copy($data->profile_picture, $model->profile_picture );

        $model->save();

        return redirect()->route("account.index");
    }
}
