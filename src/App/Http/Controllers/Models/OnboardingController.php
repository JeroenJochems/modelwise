<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Domain\Models\Data\ModelDigitalData;
use Domain\Models\Data\ModelPersonalDetailsData;
use Domain\Models\Data\ModelPhotoData;
use Domain\Models\Data\ModelProfilePictureData;
use Domain\Models\Data\ModelSocialsData;
use Domain\Models\Models\Model;
use Domain\Models\Models\Digital;
use Domain\Models\Models\Photo;
use Domain\Models\Repositories\PhotoRepository;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OnboardingController extends Controller
{
    public function personalDetails()
    {
        return Inertia::render("Model/Onboarding/PersonalDetails")
            ->with(['modelData' => ModelPersonalDetailsData::from(auth()->user())]);
    }

    public function storePersonalDetails(ModelPersonalDetailsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());
        $model->gender = $data->gender;
        $model->save();

        return redirect()->route('onboarding.profile-picture')->with(['modelData' => $data]);
    }


    public function profilePicture()
    {
        return Inertia::render("Model/Onboarding/ProfilePicture")
            ->with(['modelData' => ModelProfilePictureData::from(auth()->user())]);
    }

    public function storeProfilePicture(ModelProfilePictureData $data)
    {
        /** @var Model $model */
        $model = auth()->user();
        $model->profile_picture = str_replace("tmp/", "profile_pictures/", $data->profile_picture);

        Storage::copy($data->profile_picture, $model->profile_picture );

        $model->save();

        return redirect()->route('onboarding.photos');
    }

    public function photos(PhotoRepository $photos)
    {
        return Inertia::render("Model/Onboarding/Photos")->with([
            'modelPhotos' => $photos->getPhotos(auth()->user(), Photo::FOLDER_WORK_EXPERIENCE)
        ]);
    }

    public function deleteDigital(Digital $digital)
    {
        $digital->delete();
        redirect(back());
    }

    public function digitals(PhotoRepository $photoRepository)
    {
        return Inertia::render("Model/Onboarding/Digitals")->with([
            'modelDigitals' => $photoRepository->getPhotos(auth()->user(), Photo::FOLDER_DIGITALS)
        ]);
    }

    public function storeDigitals(ModelDigitalData $data)
    {
        $digital = new Digital;
        $digital->model_id = auth()->id();
        $digital->path = str_replace("tmp/", "digitals/", $data->path);

        Storage::copy($data->path, $digital->path );

        $digital->save();

        return redirect()->route('onboarding.digitals');
    }


    public function socials()
    {
        return Inertia::render("Model/Onboarding/Socials")
            ->with([
                'modelData' => ModelSocialsData::from(auth()->user())->toArray()
            ]);
    }

    public function storeSocials(ModelSocialsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());

        if ($data->website == "http://") $model->website = null;

        $model->has_completed_onboarding = true;
        $model->save();

        return redirect()->route('onboarding.thanks');
    }

    public function subscribe()
    {
        $model = auth()->user();
        $model->is_subscribed_to_newsletter = true;
        $model->save();

        return redirect()->route('dashboard');
    }

    public function thanks()
    {

        return Inertia::render("Model/Onboarding/Thanks")->with([
            'is_subscribed' => auth()->user()->is_subscribed_to_newsletter
        ]);
    }

    public function notAccepted()
    {
        return Inertia::render("Model/Onboarding/NotAccepted");
    }

}
