<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Domain\Models\Data\ModelPersonalDetailsData;
use Domain\Models\Data\ModelProfilePictureData;
use Domain\Models\Models\Model;
use Domain\Models\Models\Photo;
use Inertia\Inertia;
use PhpParser\Node\Expr\AssignOp\Mod;

class OnboardingController extends Controller
{
    public function personalDetails()
    {
        return Inertia::render("Model/Onboarding/PersonalDetails")
            ->with([
                'modelData' => ModelPersonalDetailsData::from(auth()->user())->toArray()
            ]);
    }

    public function storePersonalDetails(ModelPersonalDetailsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());

        return redirect()->route('onboarding.profile-picture')->with(['modelData' => $data]);
    }


    public function profilePicture()
    {
        return Inertia::render("Model/Onboarding/ProfilePicture");
    }

    public function storeProfilePicture(ModelProfilePictureData $data)
    {
        /** @var Model $model */
        $model = auth()->user();
        $model->profile_picture = $data->profile_picture->store("profile_pictures");
        $model->save();

        return redirect()->route('onboarding.photos');
    }

    public function photos()
    {
        return Inertia::render("Model/Onboarding/Photos")->with(['modelData' => ModelPersonalDetailsData::from(auth()->user())->toArray()]);
    }

}
