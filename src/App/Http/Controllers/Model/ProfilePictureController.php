<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfilePictureController extends BaseOnboardingController
{
    public function index()
    {
        /** @var Model|Authenticatable $model */
        $model = auth()->user();
        $profilePicture = $model->profile_picture;

        return Inertia::render("Model/Onboarding/ProfilePicture")
            ->with(['profile_picture' => $profilePicture ? ["path" => $model->profilePictureCdn."?w=600&h=600&fit=crop&crop=faces",] : null]);
    }

    public function store()
    {
        $profilePicture = request()->get("profile_picture");

        if ($profilePicture && isset($profilePicture['tmpFile'])) {

            /** @var Model $model */
            $model = auth()->user();
            $model->profile_picture = str_replace("tmp/", "profile_pictures/", $profilePicture['tmpFile']);

            Storage::copy($profilePicture['tmpFile'], $model->profile_picture);

            $model->save();
        }

        return $this->nextOrReturn();
    }
}
